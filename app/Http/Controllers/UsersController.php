<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    //
    public function index()
    {
        $user = User::all();

        $data = [
            'user' => $user
        ];
        return view('admin.user.index', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string',
            'password' => 'nullable|min:6'
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh user lain.',

            'phone.string' => 'Nomor telepon harus berupa teks.',

            'password.min' => 'Password minimal harus 6 karakter.'
        ]);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'User berhasil diperbarui');
    }

    public function toggle($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'is_active' => !$user->is_active
        ]);

        return redirect()->back()->with('success', 'Status user berhasil diperbarui');
    }
}
