<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admin Dashboard Data
            $totalOrders = Order::count();
            $monthlyOrders = Order::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();

            $totalRevenue = Order::whereIn('status', ['paid', 'shipped', 'completed'])
                ->sum('grand_total');

            $monthlyRevenue = Order::whereIn('status', ['paid', 'shipped', 'completed'])
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('grand_total');

            $outOfStock = Products::where('stock', '<=', 0)->count();

            $recentOrders = Order::with('buyer')
                ->latest()
                ->take(5)
                ->get();

            // Basic stock list for admin
            $productsStock = Products::latest()->take(5)->get();

            $topSellingProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(price * quantity) as total_earnings'))
                ->with('product')
                ->groupBy('product_id')
                ->orderByDesc('total_sold')
                ->take(5)
                ->get();

            return view('admin.dashboard.index', compact(
                'totalOrders',
                'monthlyOrders',
                'totalRevenue',
                'monthlyRevenue',
                'outOfStock',
                'recentOrders',
                'productsStock',
                'topSellingProducts'
            ));

        } elseif ($user->role === 'seller') {
            // Seller Dashboard Data
            // Orders containing seller's products
            $sellerId = $user->id;

            $totalOrders = Order::whereHas('items', function ($query) use ($sellerId) {
                $query->where('seller_id', $sellerId);
            })->count();

            $monthlyOrders = Order::whereHas('items', function ($query) use ($sellerId) {
                $query->where('seller_id', $sellerId);
            })->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();

            // Calculate revenue for this seller only
            $totalRevenue = OrderItem::where('seller_id', $sellerId)
                ->whereHas('order', function ($query) {
                    $query->whereIn('status', ['paid', 'shipped', 'completed']);
                })
                ->sum('subtotal'); // Assuming subtotal is valid for revenue calculation per item

            // If subtotal is not strictly item price * qty in OrderItem, we might need a join. 
            // But usually OrderItem has price and quantity. Let's assume subtotal exists or calculate it.
            // Checking OrderItem model earlier, it didn't show columns, but typical schema has total/subtotal.
            // Let's safe bet: price * quantity
            $totalRevenue = OrderItem::where('seller_id', $sellerId)
                ->whereHas('order', function ($query) {
                    $query->whereIn('status', ['paid', 'shipped', 'completed']);
                })
                ->get()
                ->sum(function ($item) {
                    return $item->price * $item->quantity;
                });

            $monthlyRevenue = OrderItem::where('seller_id', $sellerId)
                ->whereHas('order', function ($query) {
                    $query->whereIn('status', ['paid', 'shipped', 'completed'])
                        ->whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year);
                })
                ->get()
                ->sum(function ($item) {
                    return $item->price * $item->quantity;
                });

            // Seller's products stock
            $productsStock = Products::where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get();
            $outOfStock = Products::where('user_id', $user->id)
                ->where('stock', '<=', 0)
                ->count();

            // Recent orders for this seller
            $recentOrders = Order::whereHas('items', function ($query) use ($sellerId) {
                $query->where('seller_id', $sellerId);
            })
                ->with([
                    'buyer',
                    'items' => function ($q) use ($sellerId) {
                        $q->where('seller_id', $sellerId);
                    }
                ])
                ->latest()
                ->take(5)
                ->get();

            return view('seller.dashboard.index', compact(
                'totalOrders',
                'monthlyOrders',
                'totalRevenue',
                'monthlyRevenue',
                'outOfStock',
                'recentOrders',
                'productsStock'
            ));
        }

        return abort(403);
    }
}
