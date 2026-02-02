<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellerOrderController extends Controller
{
    /**
     * Display a listing of orders for seller
     */
    public function index(Request $request)
    {
        $sellerId = Auth::id();

        // Get orders that contain products from this seller
        $query = Order::with(['items.product', 'buyer', 'shipment'])
            ->whereHas('items', function ($q) use ($sellerId) {
                $q->where('seller_id', $sellerId);
            });

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
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
                $q->where('order_code', 'like', "%{$search}%")
                    ->orWhereHas('buyer', function ($bq) use ($search) {
                        $bq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $orders = $query->orderByDesc('created_at')->paginate(15);

        // Calculate seller's portion for each order
        foreach ($orders as $order) {
            $order->seller_total = $order->items
                ->where('seller_id', $sellerId)
                ->sum('subtotal');
        }

        // Statistics
        $stats = [
            'total' => Order::whereHas('items', function ($q) use ($sellerId) {
                $q->where('seller_id', $sellerId);
            })->count(),
            'pending' => Order::whereHas('items', function ($q) use ($sellerId) {
                $q->where('seller_id', $sellerId);
            })->where('status', 'pending')->count(),
            'paid' => Order::whereHas('items', function ($q) use ($sellerId) {
                $q->where('seller_id', $sellerId);
            })->where('status', 'paid')->count(),
            'processed' => Order::whereHas('items', function ($q) use ($sellerId) {
                $q->where('seller_id', $sellerId);
            })->where('status', 'processed')->count(),
            'shipped' => Order::whereHas('items', function ($q) use ($sellerId) {
                $q->where('seller_id', $sellerId);
            })->where('status', 'shipped')->count(),
            'completed' => Order::whereHas('items', function ($q) use ($sellerId) {
                $q->where('seller_id', $sellerId);
            })->where('status', 'completed')->count(),
            'cancelled' => Order::whereHas('items', function ($q) use ($sellerId) {
                $q->where('seller_id', $sellerId);
            })->where('status', 'cancelled')->count(),
        ];

        return view('seller.orders.index', compact('orders', 'stats'));
    }

    /**
     * Display the specified order
     */
    public function show($uuid)
    {
        $sellerId = Auth::id();

        $order = Order::with([
            'items.product.primaryImage',
            'buyer',
            'shipment'
        ])
            ->where('uuid', $uuid)
            ->whereHas('items', function ($q) use ($sellerId) {
                $q->where('seller_id', $sellerId);
            })
            ->firstOrFail();

        // Filter items to only show seller's items
        $order->seller_items = $order->items->where('seller_id', $sellerId);
        $order->seller_total = $order->seller_items->sum('subtotal');

        // Get available couriers
        $couriers = [
            'JNE' => 'JNE',
            'TIKI' => 'TIKI',
            'POS Indonesia' => 'POS Indonesia',
            'J&T Express' => 'J&T Express',
            'SiCepat' => 'SiCepat',
            'Ninja Express' => 'Ninja Express',
            'AnterAja' => 'AnterAja',
            'ID Express' => 'ID Express',
        ];

        return view('seller.orders.show', compact('order', 'couriers'));
    }

    /**
     * Process the order (change status from paid to processed)
     */
    public function process($uuid)
    {
        $sellerId = Auth::id();

        $order = Order::where('uuid', $uuid)
            ->whereHas('items', function ($q) use ($sellerId) {
                $q->where('seller_id', $sellerId);
            })
            ->firstOrFail();

        if ($order->status !== 'paid') {
            return back()->with('error', 'Pesanan tidak dapat diproses. Status harus PAID.');
        }

        $order->update([
            'status' => 'processed',
            'processed_at' => now(),
        ]);

        return back()->with('success', 'Pesanan sedang diproses. Silakan siapkan barang untuk dikirim.');
    }

    /**
     * Ship the order (update shipment info and change status to shipped)
     */
    public function ship(Request $request, $uuid)
    {
        $request->validate([
            'courier' => 'required|string|max:100',
            'tracking_number' => 'required|string|max:100',
        ], [
            'courier.required' => 'Kurir wajib dipilih.',
            'tracking_number.required' => 'Nomor resi wajib diisi.',
        ]);

        $sellerId = Auth::id();

        try {
            DB::beginTransaction();

            $order = Order::where('uuid', $uuid)
                ->whereHas('items', function ($q) use ($sellerId) {
                    $q->where('seller_id', $sellerId);
                })
                ->firstOrFail();

            if (!in_array($order->status, ['paid', 'processed'])) {
                return back()->with('error', 'Pesanan tidak dapat dikirim. Status harus PAID atau PROCESSED.');
            }

            // Update or create shipment
            $shipmentData = [
                'courier' => $request->courier,
                'tracking_number' => $request->tracking_number,
                'shipping_status' => 'shipped',
                'shipped_at' => now(),
                'updated_at' => now(),
            ];

            $existingShipment = DB::table('shipments')->where('order_id', $order->id)->first();

            if ($existingShipment) {
                DB::table('shipments')
                    ->where('order_id', $order->id)
                    ->update($shipmentData);
            } else {
                $shipmentData['uuid'] = \Illuminate\Support\Str::uuid();
                $shipmentData['order_id'] = $order->id;
                $shipmentData['created_at'] = now();
                DB::table('shipments')->insert($shipmentData);
            }

            // Update order status
            $order->update([
                'status' => 'shipped',
            ]);

            DB::commit();

            return back()->with('success', 'Pesanan berhasil dikirim. Nomor resi: ' . $request->tracking_number);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengirim pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Update tracking number for shipped order
     */
    public function updateTracking(Request $request, $uuid)
    {
        $request->validate([
            'courier' => 'required|string|max:100',
            'tracking_number' => 'required|string|max:100',
        ]);

        $sellerId = Auth::id();

        $order = Order::where('uuid', $uuid)
            ->whereHas('items', function ($q) use ($sellerId) {
                $q->where('seller_id', $sellerId);
            })
            ->firstOrFail();

        if ($order->status !== 'shipped') {
            return back()->with('error', 'Hanya pesanan yang sudah dikirim yang dapat diupdate resinya.');
        }

        DB::table('shipments')
            ->where('order_id', $order->id)
            ->update([
                'courier' => $request->courier,
                'tracking_number' => $request->tracking_number,
                'updated_at' => now(),
            ]);

        return back()->with('success', 'Nomor resi berhasil diupdate.');
    }
}
