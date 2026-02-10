<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\MailHelper;
use Illuminate\Http\Request;

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

        $users = User::query()
            ->where('is_subscribed', true)
            ->where('is_active', true)
            ->get();

        foreach ($users as $user) {
            MailHelper::send($user->email, $request->subject, 'admin.announcement.email', [
                'subjectLine' => $request->subject,
                'content' => $request->message,
            ]);
        }

        return redirect()->route('admin.announcement.create')->with('success', 'Pengumuman berhasil dikirim ke ' . $users->count() . ' pengguna.');
    }
}
