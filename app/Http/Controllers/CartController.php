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
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('info', 'Silakan login terlebih dahulu untuk melihat keranjang.');
        }

        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart) {
            return view('home.cart.index', ['items' => collect(), 'total' => 0]);
        }

        $items = DB::table('cart_items')
            ->join('products', 'products.id', '=', 'cart_items.product_id')
            ->where('cart_items.cart_id', $cart->id)
            ->select(
                'cart_items.id as cart_item_id',
                'products.id',
                'products.name',
                'products.weight',
                'cart_items.quantity',
                'cart_items.price',
                DB::raw('(cart_items.quantity * cart_items.price) as subtotal')
            )
            ->get();

        $total = $items->sum('subtotal');

        return view('home.cart.index', compact('items', 'total'));
    }

    public function add(Request $request, Products $product)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('info', 'Silakan login terlebih dahulu untuk menambahkan ke keranjang.')
                ->with('intended', url()->previous());
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
