<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use App\Models\Products;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        $category = CategoryProduct::where('is_active', true)
        ->withCount([
            'products as products_count' => function ($q) {
                $q->where('status', 'active');
            }
        ])
        ->get();

        $popularProducts = Products::with('primaryImage')
            ->where('status', 'active')
            ->orderBy('price', 'asc')
            ->limit(8)
            ->get();

        $data = [
            'category' => $category,
            'popularProducts' => $popularProducts,
        ];

        return view('home.index', compact('data'));
    }

    public function product()
    {
        $category = CategoryProduct::where('is_active', true)
        ->withCount([
            'products as products_count' => function ($q) {
                $q->where('status', 'active');
            }
        ])
        ->get();

        $popularProducts = Products::with('primaryImage')
            ->where('status', 'active')
            ->orderBy('price', 'asc')
            ->limit(8)
            ->get();

        $data = [
            'category' => $category,
            'popularProducts' => $popularProducts,
        ];

        return view('home.product', compact('data'));
    }
}
