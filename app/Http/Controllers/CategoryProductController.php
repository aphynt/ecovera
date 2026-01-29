<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryProductController extends Controller
{
    //
    public function index()
    {
        $category = CategoryProduct::all();
        return view('admin.category.index', compact('category'));
    }

    public function create(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
            'is_active'   => 'nullable|boolean',
        ]);

        try {
            $path = $request->file('image')->storeAs('categories', uniqid() . '.' . $request->image->extension(), 'public');

            $category = CategoryProduct::create([
                'name'        => $validated['name'],
                'slug'        => Str::slug($validated['name']),
                'image_url'   => $path,
                'description' => $validated['description'] ?? null,
                'is_active'   => $validated['is_active'] ?? true,
            ]);

            return redirect()->back()->with('success', 'Kategori produk berhasil ditambahkan');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('info', 'Kategori produk gagal ditambahkan', $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $category = CategoryProduct::findOrFail($id);

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            if ($request->hasFile('image')) {

                if ($category->image_url && Storage::disk('public')->exists($category->image_url)) {
                    Storage::disk('public')->delete($category->image_url);
                }
                $path = $request->file('image')->storeAs('categories', uniqid() . '.' . $request->image->extension(), 'public');

                $category->image_url = $path;
            }

            $category->update([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'is_active' => $request->has('is_active'),
            ]);

            return redirect()->back()->with('success', 'Kategori produk berhasil diperbarui');

        } catch (\Throwable $th) {
            return redirect()->back()->with('info', 'Kategori produk gagal diperbarui');
        }
    }

    public function destroy($id)
    {
        $category = CategoryProduct::findOrFail($id);

        try {
            if ($category->image_url && Storage::disk('public')->exists($category->image_url)) {
                Storage::disk('public')->delete($category->image_url);
            }

            $category->delete();

            return redirect()->back()->with('success', 'Kategori produk berhasil dihapus');

        } catch (\Throwable $th) {
            return redirect()->back()->with('info', 'Kategori produk gagal dihapus');
        }
    }
}
