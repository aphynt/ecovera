<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LockScreenController extends Controller
{
    //
    public function lock()
    {
        session(['locked' => true]);
        return redirect()->route('admin.lock.screen');
    }

    public function show()
    {
        return view('auth.lock-screen');
    }

    public function unlock(Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);

        if (!Hash::check($request->password, Auth::user()->password)) {
            return back()->withErrors(['password' => 'Password salah']);
        }

        session()->forget('locked');
        return redirect()->route('admin.dashboard.index');
    }
}
