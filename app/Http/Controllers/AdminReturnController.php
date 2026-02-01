<?php

namespace App\Http\Controllers;

use App\Models\ReturnRequest;
use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminReturnController extends Controller
{
    /**
     * Display a listing of return requests (monitoring all returns)
     */
    public function index(Request $request)
    {
        $query = ReturnRequest::with(['order', 'buyer', 'seller', 'items.product', 'processor']);

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

        // Search by order code, buyer name, or seller name
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('order', function ($oq) use ($search) {
                    $oq->where('order_code', 'like', "%{$search}%");
                })->orWhereHas('buyer', function ($bq) use ($search) {
                    $bq->where('name', 'like', "%{$search}%");
                })->orWhereHas('seller', function ($sq) use ($search) {
                    $sq->where('name', 'like', "%{$search}%");
                });
            });
        }

        $returns = $query->orderByDesc('created_at')->paginate(15);

        // Statistics
        $stats = [
            'total' => ReturnRequest::count(),
            'requested' => ReturnRequest::where('return_status', 'requested')->count(),
            'approved' => ReturnRequest::where('return_status', 'approved')->count(),
            'rejected' => ReturnRequest::where('return_status', 'rejected')->count(),
            'item_sent_back' => ReturnRequest::where('return_status', 'item_sent_back')->count(),
            'item_received' => ReturnRequest::where('return_status', 'item_received')->count(),
            'refunded' => ReturnRequest::where('return_status', 'refunded')->count(),
        ];

        return view('admin.returns.index', compact('returns', 'stats'));
    }

    /**
     * Display the specified return request
     */
    public function show($uuid)
    {
        $return = ReturnRequest::with([
            'order.items.product',
            'buyer',
            'seller',
            'items.product',
            'shipment',
            'processor',
            'refund'
        ])
            ->where('uuid', $uuid)
            ->firstOrFail();

        return view('admin.returns.show', compact('return'));
    }

    /**
     * Process refund (Admin only - after seller confirms item received)
     */
    public function processRefund(Request $request, $uuid)
    {
        $request->validate([
            'refund_amount' => 'required|numeric|min:0',
            'admin_note' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            $return = ReturnRequest::where('uuid', $uuid)
                ->where('return_status', 'item_received')
                ->firstOrFail();

            // Get payment from order
            $payment = \App\Models\Payment::where('order_id', $return->order_id)->first();

            // Create refund record using query builder
            DB::table('refunds')->insert([
                'uuid' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'return_id' => $return->id,
                'payment_id' => $payment?->id ?? 0,
                'refund_amount' => $request->input('refund_amount'),
                'refund_status' => 'success',
                'refunded_at' => now(),
            ]);

            $return->return_status = 'refunded';
            $return->admin_note = $request->input('admin_note') ?? $return->admin_note;
            $return->processed_by = Auth::id();
            $return->save();

            // Update order
            $return->order->update([
                'return_status' => 'refunded',
                'return_completed_at' => now(),
            ]);

            DB::commit();

            return redirect()
                ->route('admin.returns.show', $uuid)
                ->with('success', 'Refund berhasil diproses. Dana telah dikembalikan ke pembeli.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Gagal memproses refund: ' . $e->getMessage());
        }
    }

    /**
     * Cancel/void a refund (Admin only - for correction purposes)
     */
    public function cancelRefund(Request $request, $uuid)
    {
        $request->validate([
            'admin_note' => 'required|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            $return = ReturnRequest::where('uuid', $uuid)
                ->where('return_status', 'refunded')
                ->firstOrFail();

            // Update refund status to failed
            if ($return->refund) {
                $return->refund->update([
                    'refund_status' => 'failed',
                ]);
            }

            $return->return_status = 'item_received';
            $return->admin_note = $request->input('admin_note');
            $return->processed_by = Auth::id();
            $return->save();

            DB::commit();

            return redirect()
                ->route('admin.returns.show', $uuid)
                ->with('success', 'Refund telah dibatalkan. Status kembali ke "Barang Diterima".');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Gagal membatalkan refund: ' . $e->getMessage());
        }
    }
}
