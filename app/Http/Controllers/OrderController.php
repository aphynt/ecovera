<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //
    public function show($orderId)
    {
        $order = DB::table('orders')
            ->where('id', $orderId)
            ->where('buyer_id', Auth::id())
            ->first();

        if (!$order) {
            abort(404);
        }

        $items = DB::table('order_items')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('order_items.order_id', $orderId)
            ->select(
                'products.name',
                'order_items.quantity',
                'order_items.price',
                'order_items.subtotal'
            )
            ->get();

        return view('home.orders.show', compact('order', 'items'));
    }
}
