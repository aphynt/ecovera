<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartController extends Controller
{
    //
    public function add(Request $request, Products $product)
    {
        if (!Auth::check()) {
            return redirect()->back()
                ->with('info', 'Silakan login terlebih dahulu untuk menambahkan ke keranjang.');
        }

        $user = Auth::user();

        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart) {
            $cartId = Cart::insertGetId([
                'uuid' => Str::uuid(),
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $cartId = $cart->id;
        }

        $cartItem = CartItem::where('cart_id', $cartId)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            CartItem::where('id', $cartItem->id)
                ->update([
                    'quantity' => $cartItem->quantity + 1,
                    'updated_at' => now(),
                ]);
        } else {
            CartItem::insert([
                'uuid' => Str::uuid(),
                'cart_id' => $cartId,
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function remove($id)
    {
        CartItem::where('id', $id)->delete();

        return back();
    }
}
