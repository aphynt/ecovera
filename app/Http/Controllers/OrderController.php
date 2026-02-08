<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //
    public function show($uuid)
    {
        $order = Order::with('buyer', 'items.product')
            ->where('uuid', $uuid)
            ->firstOrFail();

        $items = DB::table('order_items')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('product_images', function ($join) {
                $join->on('products.id', '=', 'product_images.product_id')
                    ->where('product_images.is_primary', 1);
            })
            ->where('order_items.order_id', $order->id)
            ->select(
                'products.name as product_name',
                'order_items.quantity',
                'order_items.price',
                'order_items.subtotal',
                'product_images.image_url as product_image'
            )
            ->get();

        return view('admin.orders.show', compact('order', 'items'));
    }
}
