<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    //
    public function index()
    {
        if (Auth::user()->role === 'seller') {
            $stores = Store::where('user_id', Auth::id())->get();
        } else {
            $stores = Store::all();
        }

        return view('admin.store.index', compact('stores'));
    }

    public function insert()
    {
        return view('admin.store.insert');
    }

    public function create(Request $request)
    {

        try {
            Store::create([
                'user_id'     => Auth::user()->id,
                'store_name'  => $request->store_name,
                'store_slug' => Str::slug($request->store_name),
                'description' => $request->description,
                'address'     => $request->address,
            ]);

            return redirect()->route('admin.store')->with('success', 'Toko berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->route('admin.store.insert')->with('info', 'Toko gagal ditambahkan..\n'. $th->getMessage());
        }
    }

    public function edit($uuid)
    {
        $store = Store::where('uuid', $uuid)->first();

        return view('admin.store.edit', compact('store'));
    }

    public function update(Request $request, $uuid)
    {
        $store = Store::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'store_name' => 'required|string|max:255',
        ]);

        $store->update([
            'store_name'  => $request->store_name,
            'description' => $request->description,
            'address'     => $request->address,
        ]);

        return redirect()->route('admin.store')->with('success', 'Data toko berhasil diperbarui');
    }

    public function verify($uuid)
    {
        $store = Store::where('uuid', $uuid)->firstOrFail();

        try {
            $store->update([
                'is_verified' => 1
            ]);

            return redirect()->back()->with('success', 'Toko berhasil diverifikasi');
        } catch (\Throwable $th) {
            return redirect()->back()->with('info', 'Toko gagal diverifikasi');
        }
    }
}
