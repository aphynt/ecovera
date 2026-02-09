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

    public function allProducts(Request $request)
    {
        $categories = CategoryProduct::where('is_active', true)
            ->withCount([
                'products as products_count' => function ($q) {
                    $q->where('status', 'active');
                }
            ])
            ->get();

        $productsQuery = Products::with(['primaryImage', 'category'])
            ->where('status', 'active');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $productsQuery->where('name', 'like', "%{$search}%");
        }

        $products = $productsQuery->orderBy('created_at', 'desc')
            ->paginate(12)
            ->appends(['search' => $request->search]);

        $data = [
            'categories' => $categories,
            'products' => $products,
            'pageTitle' => 'Semua Produk',
            'categoryName' => null,
            'categoryDescription' => null,
        ];

        return view('home.products-list', compact('data'));
    }

    public function productsByCategory(Request $request, $slug)
    {
        $category = CategoryProduct::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $categories = CategoryProduct::where('is_active', true)
            ->withCount([
                'products as products_count' => function ($q) {
                    $q->where('status', 'active');
                }
            ])
            ->get();

        $productsQuery = Products::with(['primaryImage', 'category'])
            ->where('category_id', $category->id)
            ->where('status', 'active');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $productsQuery->where('name', 'like', "%{$search}%");
        }

        $products = $productsQuery->orderBy('created_at', 'desc')
            ->paginate(12)
            ->appends(['search' => $request->search]);

        $data = [
            'categories' => $categories,
            'products' => $products,
            'pageTitle' => $category->name,
            'categoryName' => $category->name,
            'categoryDescription' => $category->description,
        ];

        return view('home.products-list', compact('data'));
    }

    public function productDetail($uuid)
    {
        $product = Products::with(['primaryImage', 'category', 'store', 'images'])
            ->where('uuid', $uuid)
            ->where('status', 'active')
            ->firstOrFail();

        $relatedProducts = Products::with('primaryImage')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->limit(4)
            ->get();

        $data = [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ];

        return view('home.product-detail', compact('data'));
    }
}
