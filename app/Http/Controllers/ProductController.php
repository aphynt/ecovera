<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use App\Models\ProductImages;
use App\Models\Products;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    //
    public function index()
    {
        $products = DB::table('products as pr')
        ->leftJoin('stores as st', 'pr.store_id', 'st.id')
        ->leftJoin('categories as ct', 'pr.category_id', 'ct.id')
        ->select(
            'pr.id',
            'pr.uuid',
            'pr.is_active',
            'pr.store_id',
            'st.user_id',
            'st.store_name',
            'pr.category_id',
            'ct.name as category_name',
            'pr.name',
            'pr.slug',
            'pr.description',
            'pr.price',
            'pr.stock',
            'pr.weight',
            'pr.status',
        )
        ->where('pr.is_active', true);
        if(Auth::user()->role == 'admin'){
            $products = $products->get();
        }else{
            $products = $products->where('st.user_id', Auth::user()->id)->get();
        }

        $data = [
            'products' => $products,
        ];

        return view('admin.product.index', compact('data'));
    }

    public function insert()
    {
        $stores = Store::where('user_id', Auth::user()->id)->get();
        $categories = CategoryProduct::where('is_active', true)->get();

        $data = [
            'stores' => $stores,
            'categories' => $categories,
        ];
        return view('admin.product.insert', compact('data'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'store_id'    => 'required|exists:stores,id',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0'
        ]);


        try {

        DB::transaction(function () use ($request) {

            $product = Products::create([
                'uuid'        => Str::uuid(),
                'store_id'    => $request->store_id,
                'category_id' => $request->category_id,
                'name'        => $request->name,
                'slug'        => Str::slug($request->name),
                'description' => $request->description,
                'price'       => $request->price,
                'stock'       => $request->stock,
                'weight'      => $request->weight,
                'is_active'      => 1,
                'status'      => 'inactive',
            ]);

            // SIMPAN GAMBAR (BANYAK)
            if ($request->hasFile('images')) {

                foreach ($request->file('images') as $index => $image) {

                    $path = $image->store('products/images', 'public');

                    ProductImages::create([
                        'product_id' => $product->id,
                        'image_url'  => $path,
                        'is_primary' => ($index == $request->primary_image_index),
                    ]);
                }
            }

            // SIMPAN VIDEO (SATU SAJA)
            if ($request->hasFile('video')) {

                $videoPath = $request->file('video')
                    ->store('products/videos', 'public');

                $product->update([
                    'video_url' => $videoPath
                ]);
            }
        });

        return redirect()->route('admin.product')->with('success', 'Produk berhasil ditambahkan');

        } catch (\Throwable $th) {
            return redirect()->back()->with('info', 'Produk gagal ditambahkan..\n'. $th->getMessage());
        }
    }

    public function edit($uuid)
    {
        $product = Products::where('uuid', $uuid)->firstOrFail();

        $productImages = ProductImages::where('product_id', $product->id)->get();
        $stores = Store::where('user_id', Auth::id())->get();
        $categories = CategoryProduct::where('is_active', true)->get();

        $data = [
            'product'        => $product,
            'productImages'  => $productImages,
            'stores'         => $stores,
            'categories'     => $categories,
            'isReadOnly'     => $product->status === 'active',
        ];

        return view('admin.product.edit', compact('data'));
    }


    public function update(Request $request, $uuid)
    {
        $product = Products::where('uuid', $uuid)->firstOrFail();

        if ($product->status === 'active') {
            return back()->with('info', 'Produk yang sudah diverifikasi tidak dapat diedit.');
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'store_id'    => 'required|exists:stores,id',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'video'       => 'nullable|mimes:mp4,mov,avi|max:10240',
        ]);

        try {
            DB::transaction(function () use ($request, $product) {
                $product->update([
                    'store_id'    => $request->store_id,
                    'category_id' => $request->category_id,
                    'name'        => $request->name,
                    'slug'        => Str::slug($request->name),
                    'description' => $request->description,
                    'price'       => $request->price,
                    'stock'       => $request->stock,
                    'weight'      => $request->weight,
                ]);

                if ($request->hasFile('images')) {

                    if ($request->filled('primary_image_index')) {
                        ProductImages::where('product_id', $product->id)
                            ->update(['is_primary' => 0]);
                    }

                    foreach ($request->file('images') as $index => $image) {

                        $path = $image->store('products/images', 'public');

                        ProductImages::create([
                            'product_id' => $product->id,
                            'image_url'  => $path,
                            'is_primary' => $request->filled('primary_image_index')
                                && $index == $request->primary_image_index,
                        ]);
                    }
                }

                /* =======================
                * UPDATE VIDEO (SINGLE)
                * ======================= */
                if ($request->hasFile('video')) {

                    // Hapus video lama jika ada
                    if ($product->video_url
                        && Storage::disk('public')->exists($product->video_url)) {
                        Storage::disk('public')->delete($product->video_url);
                    }

                    $videoPath = $request->file('video')
                        ->store('products/videos', 'public');

                    $product->update([
                        'video_url' => $videoPath
                    ]);
                }

            });

            return redirect()->route('admin.product')->with('success', 'Produk berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()->with('info', 'Produk gagal diperbarui');
        }
    }

    public function verify(string $uuid)
    {
        $product = Products::where('uuid', $uuid)->firstOrFail();

        // Guard: cegah verifikasi ulang
        if ($product->status === 'active') {
            return redirect()
                ->back()
                ->with('error', 'Produk ini sudah diverifikasi.');
        }

        $product->update([
            'status'        => 'active',
        ]);

        return redirect()->route('admin.product')->with('success', 'Produk berhasil diverifikasi.');
    }

    public function destroy($uuid)
    {
        $product = Products::where('uuid', $uuid)->firstOrFail();
        $imageProducts = ProductImages::where('product_id', $product->id)->get();

        try {

            foreach ($imageProducts as $image) {

                if ($image->image_url && Storage::disk('public')->exists($image->image_url)) {
                    Storage::disk('public')->delete($image->image_url);
                }

                $image->delete();
            }
            $product->delete();

            return redirect()->route('admin.product')->with('success', 'Produk berhasil dihapus');

        } catch (\Throwable $th) {

            return redirect()->back()->with('error', 'Produk gagal dihapus');
        }
    }
}
