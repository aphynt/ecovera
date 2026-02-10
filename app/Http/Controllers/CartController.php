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
                'products.stock',
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
            // Check if adding 1 more exceeds stock
            if ($cartItem->quantity + 1 > $product->stock) {
                return redirect()->back()->with('error', 'Stok produk tidak mencukupi. Stok tersedia: ' . $product->stock);
            }
            
            CartItem::where('id', $cartItem->id)
                ->update([
                    'quantity' => $cartItem->quantity + 1,
                    'updated_at' => now(),
                ]);
        } else {
            // Check if product has stock
            if ($product->stock < 1) {
                return redirect()->back()->with('error', 'Produk sedang tidak tersedia.');
            }
            
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

    public function updateQuantity(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::find($id);
        
        if (!$cartItem) {
            return response()->json(['success' => false, 'message' => 'Item tidak ditemukan.'], 404);
        }

        $product = Products::find($cartItem->product_id);
        
        if ($request->quantity > $product->stock) {
            return response()->json([
                'success' => false, 
                'message' => 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock,
                'available_stock' => $product->stock
            ], 400);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        $subtotal = $cartItem->quantity * $cartItem->price;
        
        // Calculate new total
        $cart = Cart::find($cartItem->cart_id);
        $total = DB::table('cart_items')
            ->where('cart_id', $cart->id)
            ->sum(DB::raw('quantity * price'));

        return response()->json([
            'success' => true,
            'message' => 'Jumlah produk berhasil diperbarui.',
            'subtotal' => $subtotal,
            'total' => $total,
            'formatted_subtotal' => 'Rp ' . number_format($subtotal, 0, ',', '.'),
            'formatted_total' => 'Rp ' . number_format($total, 0, ',', '.')
        ]);
    }
}
