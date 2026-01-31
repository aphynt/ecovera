<?php

namespace App\Http\Controllers;

use App\Models\ReturnRequest;
use App\Models\ReturnShipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellerReturnController extends Controller
{
    /**
     * Display a listing of return requests for seller
     */
    public function index(Request $request)
    {
        $sellerId = Auth::id();

        $query = ReturnRequest::with(['order', 'buyer', 'items.product'])
            ->where('seller_id', $sellerId);

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('return_status', $request->status);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by order code or buyer name
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('order', function ($oq) use ($search) {
                    $oq->where('order_code', 'like', "%{$search}%");
                })->orWhereHas('buyer', function ($bq) use ($search) {
                    $bq->where('name', 'like', "%{$search}%");
                });
            });
        }

        $returns = $query->orderByDesc('created_at')->paginate(15);

        // Statistics
        $stats = [
            'total' => ReturnRequest::where('seller_id', $sellerId)->count(),
            'requested' => ReturnRequest::where('seller_id', $sellerId)->where('return_status', 'requested')->count(),
            'approved' => ReturnRequest::where('seller_id', $sellerId)->where('return_status', 'approved')->count(),
            'rejected' => ReturnRequest::where('seller_id', $sellerId)->where('return_status', 'rejected')->count(),
            'item_sent_back' => ReturnRequest::where('seller_id', $sellerId)->where('return_status', 'item_sent_back')->count(),
            'item_received' => ReturnRequest::where('seller_id', $sellerId)->where('return_status', 'item_received')->count(),
            'refunded' => ReturnRequest::where('seller_id', $sellerId)->where('return_status', 'refunded')->count(),
        ];

        return view('seller.returns.index', compact('returns', 'stats'));
    }

    /**
     * Display the specified return request
     */
    public function show($uuid)
    {
        $sellerId = Auth::id();

        $return = ReturnRequest::with([
            'order.items.product',
            'buyer',
            'items.product',
            'shipment',
            'refund'
        ])
            ->where('uuid', $uuid)
            ->where('seller_id', $sellerId)
            ->firstOrFail();

        return view('seller.returns.show', compact('return'));
    }

    /**
     * Approve the return request
     */
    public function approve(Request $request, $uuid)
    {
        $request->validate([
            'seller_note' => 'nullable|string|max:1000',
            'return_address' => 'required|string|max:500',
        ]);

        $sellerId = Auth::id();

        try {
            DB::beginTransaction();

            $return = ReturnRequest::where('uuid', $uuid)
                ->where('seller_id', $sellerId)
                ->where('return_status', 'requested')
                ->firstOrFail();

            $return->return_status = 'approved';
            $return->seller_note = $request->input('seller_note');
            $return->return_address = $request->input('return_address');
            $return->approved_at = now();
            $return->save();

            DB::commit();

            return redirect()
                ->route('seller.returns.show', $uuid)
                ->with('success', 'Pengajuan pengembalian berhasil disetujui. Buyer dapat mengirimkan barang kembali ke alamat yang diberikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Gagal menyetujui pengembalian: ' . $e->getMessage());
        }
    }

    /**
     * Reject the return request
     */
    public function reject(Request $request, $uuid)
    {
        $request->validate([
            'seller_note' => 'required|string|max:1000',
        ], [
            'seller_note.required' => 'Alasan penolakan wajib diisi.',
        ]);

        $sellerId = Auth::id();

        try {
            DB::beginTransaction();

            $return = ReturnRequest::where('uuid', $uuid)
                ->where('seller_id', $sellerId)
                ->where('return_status', 'requested')
                ->firstOrFail();

            $return->return_status = 'rejected';
            $return->seller_note = $request->input('seller_note');
            $return->rejected_at = now();
            $return->save();

            DB::commit();

            return redirect()
                ->route('seller.returns.show', $uuid)
                ->with('success', 'Pengajuan pengembalian telah ditolak.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Gagal menolak pengembalian: ' . $e->getMessage());
        }
    }

    /**
     * Mark item as received from buyer
     */
    public function markReceived(Request $request, $uuid)
    {
        $request->validate([
            'seller_note' => 'nullable|string|max:1000',
            'item_condition' => 'required|in:good,damaged,missing',
        ]);

        $sellerId = Auth::id();

        try {
            DB::beginTransaction();

            $return = ReturnRequest::where('uuid', $uuid)
                ->where('seller_id', $sellerId)
                ->where('return_status', 'item_sent_back')
                ->firstOrFail();

            $itemCondition = $request->input('item_condition');

            // Get shipment record
            $shipment = DB::table('return_shipments')->where('return_id', $return->id)->first();

            // If item is damaged or missing, reject the return
            if ($itemCondition !== 'good') {
                $return->return_status = 'rejected';
                $return->seller_note = $request->input('seller_note') ?? 'Barang tidak sesuai kondisi yang diharapkan.';
                $return->save();

                // Update shipment received_at using query builder
                if ($shipment) {
                    DB::table('return_shipments')
                        ->where('return_id', $return->id)
                        ->update(['received_at' => now()]);
                }

                DB::commit();

                return redirect()
                    ->route('seller.returns.show', $uuid)
                    ->with('error', 'Barang tidak sesuai. Pengembalian ditolak.');
            }

            // If item is good, mark as received
            $return->return_status = 'item_received';
            $return->seller_note = $request->input('seller_note') ?? $return->seller_note;
            $return->save();

            // Update shipment received_at using query builder
            if ($shipment) {
                DB::table('return_shipments')
                    ->where('return_id', $return->id)
                    ->update(['received_at' => now()]);
            } else {
                // If no shipment record exists, create one
                DB::table('return_shipments')->insert([
                    'uuid' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                    'return_id' => $return->id,
                    'courier' => 'Unknown',
                    'tracking_number' => null,
                    'shipped_at' => null,
                    'received_at' => now(),
                ]);
            }

            DB::commit();

            return redirect()
                ->route('seller.returns.show', $uuid)
                ->with('success', 'Barang pengembalian telah diterima dan sesuai. Menunggu admin untuk memproses refund.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Gagal menandai barang diterima: ' . $e->getMessage());
        }
    }
}
