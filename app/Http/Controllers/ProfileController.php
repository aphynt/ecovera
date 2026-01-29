<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    //
    public function index()
    {
        return view('admin.profile.index');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string',
            'password' => 'nullable|min:6',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh user lain.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        User::where('id', $user->id)->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'avatar.required' => 'Avatar wajib diunggah.',
            'avatar.image' => 'File harus berupa gambar.',
            'avatar.mimes' => 'Format avatar harus JPG, JPEG, atau PNG.',
            'avatar.max' => 'Ukuran avatar maksimal 2 MB.',
        ]);

        $user = Auth::user();

        if ($user->avatar && Storage::disk('public')->exists('profile/'.$user->avatar)) {
            Storage::disk('public')->delete('profile/'.$user->avatar);
        }

        $filename = time().'_'.$request->avatar->getClientOriginalName();
        $request->avatar->storeAs('profile', $filename, 'public');

        User::where('id', $user->id)->update([
            'avatar' => 'profile/' . $filename
        ]);

        return back()->with('success', 'Avatar berhasil diperbarui.');
    }
}
