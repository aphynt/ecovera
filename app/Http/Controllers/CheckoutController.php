<?php

namespace App\Http\Controllers;

use App\Models\Cart;
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
            return redirect()->back()->with('info', 'Keranjang masih kosong.');
        }

        $items = DB::table('cart_items')
            ->join('products', 'products.id', '=', 'cart_items.product_id')
            ->where('cart_items.cart_id', $cart->id)
            ->select(
                'products.id',
                'products.name',
                'products.weight',
                'cart_items.quantity',
                'cart_items.price',
                DB::raw('(cart_items.quantity * cart_items.price) as subtotal')
            )
            ->get();

        if ($items->isEmpty()) {
            return redirect()->back()->with('info', 'Keranjang masih kosong.');
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

            // === CART ITEMS + SELLER ===
            $cartItems = DB::table('cart_items')
                ->join('products', 'products.id', '=', 'cart_items.product_id')
                ->join('stores', 'stores.id', '=', 'products.store_id')
                ->where('cart_items.cart_id', $cart->id)
                ->select(
                    'cart_items.*',
                    'stores.user_id as seller_id',
                    'products.name as product_name'
                )
                ->get();

            if ($cartItems->isEmpty()) {
                return back()->with('info', 'Keranjang kosong.');
            }

            // === TOTAL ===
            $totalAmount = $cartItems->sum(fn ($item) => $item->price * $item->quantity);
            $shippingCost = 0;
            $grandTotal  = $totalAmount + $shippingCost;

            // === CREATE ORDER ===
            $orderId = DB::table('orders')->insertGetId([
                'uuid'           => Str::uuid(),
                'order_code'     => 'ORD-' . now()->timestamp,
                'buyer_id'       => $user->id,
                'total_amount'   => $totalAmount,
                'shipping_cost'  => $shippingCost,
                'grand_total'    => $grandTotal,
                'status'         => 'pending',
                'payment_method' => $request->payment_method,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            // === ORDER ITEMS ===
            foreach ($cartItems as $item) {
                DB::table('order_items')->insert([
                    'uuid'       => Str::uuid(),
                    'order_id'   => $orderId,
                    'product_id' => $item->product_id,
                    'seller_id'  => $item->seller_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->price,
                    'subtotal'   => $item->price * $item->quantity,
                ]);
            }

            // =====================================================
            // =============== COD (CASH ON DELIVERY) ==============
            // =====================================================
            if ($request->payment_method === 'cod') {

                DB::table('payments')->insert([
                    'uuid'            => Str::uuid(),
                    'order_id'        => $orderId,
                    'payment_gateway' => 'cod',
                    'amount'          => $grandTotal,
                    'payment_status'  => 'pending',
                ]);

                DB::table('shipments')->insert([
                    'uuid'            => Str::uuid(),
                    'order_id'        => $orderId,
                    'courier'         => 'belum dipilih',
                    'shipping_status' => 'pending',
                ]);

                DB::table('cart_items')->where('cart_id', $cart->id)->delete();
                DB::table('carts')->where('id', $cart->id)->delete();

                DB::commit();

                return redirect()
                    ->route('orders.show', $orderId)
                    ->with('success', 'Pesanan COD berhasil dibuat.');
            }

            // =====================================================
            // ==================== MIDTRANS =======================
            // =====================================================
            Config::$serverKey    = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized  = true;
            Config::$is3ds        = true;

            $snapToken = Snap::getSnapToken([
                'transaction_details' => [
                    'order_id'     => 'ORD-' . $orderId,
                    'gross_amount' => $grandTotal,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email'      => $user->email,
                ],
            ]);

            DB::table('payments')->insert([
                'uuid'            => Str::uuid(),
                'order_id'        => $orderId,
                'payment_gateway' => 'midtrans',
                'amount'          => $grandTotal,
                'payment_status'  => 'pending',
            ]);

            DB::table('shipments')->insert([
                'uuid'            => Str::uuid(),
                'order_id'        => $orderId,
                'courier'         => 'belum dipilih',
                'shipping_status' => 'pending',
            ]);

            DB::table('cart_items')->where('cart_id', $cart->id)->delete();
            DB::table('carts')->where('id', $cart->id)->delete();

            DB::commit();

            return view('home.checkout.payment', [
                'snapToken' => $snapToken,
                'orderId'   => $orderId
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

        $orderId = str_replace('ORD-', '', $request->order_id);

        if ($request->transaction_status === 'settlement') {
            DB::table('orders')->where('id', $orderId)->update([
                'status' => 'paid'
            ]);

            DB::table('payments')->where('order_id', $orderId)->update([
                'payment_status' => 'success',
                'paid_at' => now()
            ]);
        }
    }
}

