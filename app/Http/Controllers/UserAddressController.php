<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserAddressController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'recipient_name' => 'required|string',
            'phone' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'postal_code' => 'required|string',
            'address_detail' => 'required|string',
            'is_default' => 'nullable'
        ]);

        DB::transaction(function () use ($data, $request) {

            if ($request->has('is_default')) {
                DB::table('user_addresses')
                    ->where('user_id', Auth::id())
                    ->update(['is_default' => false]);
            }

            DB::table('user_addresses')->insert([
                'uuid' => Str::uuid(),
                'user_id' => Auth::id(),
                'recipient_name' => $data['recipient_name'],
                'phone' => $data['phone'],
                'province' => $data['province'],
                'city' => $data['city'],
                'district' => $data['district'],
                'postal_code' => $data['postal_code'],
                'address_detail' => $data['address_detail'],
                'is_default' => $request->has('is_default'),
            ]);
        });

        return back()->with('success', 'Alamat berhasil ditambahkan.');
    }

    public function setDefault($uuid)
    {
        DB::transaction(function () use ($uuid) {
            // Set all addresses to not default
            DB::table('user_addresses')
                ->where('user_id', Auth::id())
                ->update(['is_default' => false]);

            // Set selected address as default
            DB::table('user_addresses')
                ->where('uuid', $uuid)
                ->where('user_id', Auth::id())
                ->update(['is_default' => true]);
        });

        return back()->with('success', 'Alamat utama berhasil diubah.');
    }

    public function delete($uuid)
    {
        $address = DB::table('user_addresses')
            ->where('uuid', $uuid)
            ->where('user_id', Auth::id())
            ->first();

        if (!$address) {
            return back()->with('error', 'Alamat tidak ditemukan.');
        }

        if ($address->is_default) {
            return back()->with('error', 'Tidak dapat menghapus alamat utama. Jadikan alamat lain sebagai alamat utama terlebih dahulu.');
        }

        DB::table('user_addresses')
            ->where('uuid', $uuid)
            ->where('user_id', Auth::id())
            ->delete();

        return back()->with('success', 'Alamat berhasil dihapus.');
    }
}
