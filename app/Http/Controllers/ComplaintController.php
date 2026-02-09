<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    public function index()
    {
        return view('home.complaint.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $complaint = new Complaint();
        if (Auth::check()) {
            $complaint->user_id = Auth::id();
            $complaint->name = Auth::user()->name;
            $complaint->email = Auth::user()->email;
        } else {
            $complaint->name = $request->name;
            $complaint->email = $request->email;
        }

        $complaint->subject = $request->subject;
        $complaint->message = $request->message;
        $complaint->save();

        return redirect()->back()->with('success', 'Pengaduan Anda telah berhasil dikirim.');
    }
}
