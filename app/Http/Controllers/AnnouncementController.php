<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\AnnouncementMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AnnouncementController extends Controller
{
    public function create()
    {
        return view('admin.announcement.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $users = User::query() // where('is_subscribed', true)
            ->where('is_active', true)
            ->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new AnnouncementMail($request->subject, $request->message));
        }

        return redirect()->route('admin.announcement.create')->with('success', 'Pengumuman berhasil dikirim ke ' . $users->count() . ' pengguna.');
    }
}
