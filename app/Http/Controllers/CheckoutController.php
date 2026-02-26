<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    //
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart) {
            return redirect()->route('cart')->with('info', 'Keranjang masih kosong.');
        }

        $items = DB::table('cart_items')
            ->join('products', 'products.id', '=', 'cart_items.product_id')
            ->where('cart_items.cart_id', $cart->id)
            ->select(
                'products.id',
                'products.name',
                'products.weight',
                'products.stock',
                'cart_items.quantity',
                'cart_items.price',
                DB::raw('(cart_items.quantity * cart_items.price) as subtotal')
            )
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart')->with('info', 'Keranjang masih kosong.');
        }

        $total = $items->sum('subtotal');

        return view('home.checkout.index', [
            'items' => $items,
            'total' => $total
        ]);
    }

    public function process(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'payment_method' => 'required|in:cod,midtrans'
        ]);

        DB::beginTransaction();

        try {

            // === CART ===
            $cart = DB::table('carts')
                ->where('user_id', $user->id)
                ->first();

            if (!$cart) {
                return back()->with('info', 'Keranjang tidak ditemukan.');
            }

            $cartItems = DB::table('cart_items')
                ->join('products', 'products.id', '=', 'cart_items.product_id')
                ->join('users', 'users.id', '=', 'products.user_id')
                ->where('cart_items.cart_id', $cart->id)
                ->select(
                    'cart_items.*',
                    'users.id as seller_id',
                    'products.name as product_name',
                    'products.stock as product_stock'
                )
                ->get();

            if ($cartItems->isEmpty()) {
                return back()->with('info', 'Keranjang kosong.');
            }

            // === VALIDATE STOCK ===
            foreach ($cartItems as $item) {
                if ($item->quantity > $item->product_stock) {
                    DB::rollBack();
                    return back()->with(
                        'error',
                        "Stok produk '{$item->product_name}' tidak mencukupi. " .
                        "Stok tersedia: {$item->product_stock}, diminta: {$item->quantity}"
                    );
                }

                if ($item->product_stock < 1) {
                    DB::rollBack();
                    return back()->with(
                        'error',
                        "Produk '{$item->product_name}' sedang tidak tersedia."
                    );
                }
            }

            // === TOTAL ===
            $totalAmount = $cartItems->sum(fn($item) => $item->price * $item->quantity);
            $shippingCost = 0;
            $grandTotal = $totalAmount + $shippingCost;

            // Generate UUID
            $orderUuid = Str::uuid();

            // Set status berdasarkan metode pembayaran
            $orderStatus = ($request->payment_method === 'cod') ? 'processed' : 'pending';
            $orderCode = 'ORD-' . now()->timestamp;

            $orderId = DB::table('orders')->insertGetId([
                'uuid' => $orderUuid,
                'order_code' => $orderCode,
                'buyer_id' => $user->id,
                'total_amount' => $totalAmount,
                'shipping_cost' => $shippingCost,
                'grand_total' => $grandTotal,
                'status' => $orderStatus,
                'payment_method' => $request->payment_method,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // === ORDER ITEMS ===
            foreach ($cartItems as $item) {
                DB::table('order_items')->insert([
                    'uuid' => Str::uuid(),
                    'order_id' => $orderId,
                    'product_id' => $item->product_id,
                    'seller_id' => $item->seller_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->price * $item->quantity,
                ]);

                // Reduce stock
                DB::table('products')
                    ->where('id', $item->product_id)
                    ->decrement('stock', $item->quantity);
            }

            if ($request->payment_method === 'cod') {

                DB::table('payments')->insert([
                    'uuid' => Str::uuid(),
                    'order_id' => $orderId,
                    'payment_gateway' => 'cod',
                    'amount' => $grandTotal,
                    'payment_status' => 'pending',
                ]);

                DB::table('shipments')->insert([
                    'uuid' => Str::uuid(),
                    'order_id' => $orderId,
                    'courier' => 'belum dipilih',
                    'shipping_status' => 'pending',
                ]);

                DB::table('cart_items')->where('cart_id', $cart->id)->delete();
                DB::table('carts')->where('id', $cart->id)->delete();

                // Auto-chat ke seller untuk COD
                $sellerId = $this->sendOrderNotificationToSellers($orderId, $orderCode, $cartItems, $user);

                DB::commit();

                // Redirect to chat with the first seller
                if ($sellerId) {
                    return redirect()
                        ->route('chat.show', $sellerId)
                        ->with('cod_success', true)
                        ->with('order_code', $orderCode)
                        ->with('popup_message', 'Pesanan COD berhasil! Chat otomatis telah dikirim ke seller.');
                } else {
                    return redirect()
                        ->route('buyer.orders.detail', $orderUuid)
                        ->with('cod_success', true)
                        ->with('order_code', $orderCode);
                }
            }

            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $snapToken = Snap::getSnapToken([
                'transaction_details' => [
                    'order_id' => 'ORD-' . $orderId,
                    'gross_amount' => $grandTotal,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
            ]);

            DB::table('payments')->insert([
                'uuid' => Str::uuid(),
                'order_id' => $orderId,
                'payment_gateway' => 'midtrans',
                'amount' => $grandTotal,
                'payment_status' => 'pending',
            ]);

            DB::table('shipments')->insert([
                'uuid' => Str::uuid(),
                'order_id' => $orderId,
                'courier' => 'belum dipilih',
                'shipping_status' => 'pending',
            ]);

            DB::table('cart_items')->where('cart_id', $cart->id)->delete();
            DB::table('carts')->where('id', $cart->id)->delete();

            DB::commit();

            return view('home.checkout.payment', [
                'snapToken' => $snapToken,
                'orderId' => $orderUuid
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('info', 'Checkout gagal. ' . $e->getMessage());
        }
    }

    public function midtransCallback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $signature = hash(
            'sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($signature !== $request->signature_key) {
            abort(403);
        }

        // Check if it's a subscription payment
        if (Str::startsWith($request->order_id, 'SUB-')) {
            $subscription = \App\Models\Subscription::where('order_id', $request->order_id)->first();

            if ($subscription && $request->transaction_status === 'settlement') {
                $subscription->update([
                    'status' => 'success'
                ]);

                \App\Models\User::where('id', $subscription->user_id)->update([
                    'is_subscribed' => true
                ]);
            } else if ($subscription && in_array($request->transaction_status, ['cancel', 'deny', 'expire'])) {
                $subscription->update([
                    'status' => 'failed'
                ]);
            }

            return response()->json(['status' => 'ok']);
        }

        // Handle regular product order payment
        $orderId = str_replace('ORD-', '', $request->order_id);

        if ($request->transaction_status === 'settlement') {
            DB::table('orders')->where('id', $orderId)->update([
                'status' => 'paid'
            ]);

            DB::table('payments')->where('order_id', $orderId)->update([
                'payment_status' => 'success',
                'paid_at' => now()
            ]);

            // Send auto-chat notification to seller for Midtrans payment
            $order = DB::table('orders')->where('id', $orderId)->first();
            if ($order) {
                $orderItems = DB::table('order_items')
                    ->join('products', 'products.id', '=', 'order_items.product_id')
                    ->join('users', 'users.id', '=', 'products.user_id')
                    ->where('order_items.order_id', $orderId)
                    ->select(
                        'order_items.*',
                        'users.id as seller_id',
                        'products.name as product_name'
                    )
                    ->get();

                if ($orderItems->isNotEmpty()) {
                    $buyer = DB::table('users')->where('id', $order->buyer_id)->first();
                    $this->sendOrderNotificationToSellers($orderId, $order->order_code, $orderItems, $buyer);
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Send auto-chat notification to sellers when COD order is placed
     */
    private function sendOrderNotificationToSellers($orderId, $orderCode, $cartItems, $buyer)
    {
        // Get buyer address
        $buyerAddress = DB::table('user_addresses')
            ->where('user_id', $buyer->id)
            ->where('is_default', 1)
            ->first();

        $addressText = $buyerAddress
            ? "{$buyerAddress->address_detail}, {$buyerAddress->district}, {$buyerAddress->city}, {$buyerAddress->province} {$buyerAddress->postal_code}"
            : "Alamat belum diset";

        $buyerPhone = $buyerAddress ? $buyerAddress->phone : ($buyer->phone ?? 'No. HP belum diset');

        // Group items by seller_id
        $itemsBySeller = $cartItems->groupBy('seller_id');
        $firstSellerId = null;

        foreach ($itemsBySeller as $sellerId => $items) {
            if (!$firstSellerId) {
                $firstSellerId = $sellerId;
            }

            // Create order summary for this seller
            $productList = [];
            $sellerTotal = 0;

            foreach ($items as $item) {
                // Get product details with image
                $product = DB::table('products')
                    ->leftJoin('product_images', function ($join) {
                        $join->on('products.id', '=', 'product_images.product_id')
                            ->where('product_images.is_primary', 1);
                    })
                    ->where('products.id', $item->product_id)
                    ->select('products.*', 'product_images.image_url')
                    ->first();

                $imageUrl = $product && $product->image_url
                    ? asset('storage/' . $product->image_url)
                    : asset('logo/logo.png');

                $productList[] = "📦 {$item->product_name}\n   Qty: {$item->quantity} x Rp " . number_format($item->price, 0, ',', '.') . " = Rp " . number_format($item->price * $item->quantity, 0, ',', '.');
                $sellerTotal += $item->price * $item->quantity;
            }

            $productListText = implode("\n\n", $productList);

            // Create simple message with order card (card will be rendered in view)
            $message = "Pesanan baru telah diterima. Mohon segera diproses!";

            // Send message to seller with order_id
            Message::create([
                'sender_id' => $buyer->id,
                'receiver_id' => $sellerId,
                'message' => $message,
                'order_id' => $orderId,
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return $firstSellerId;
    }
}
