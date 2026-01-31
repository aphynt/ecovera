<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // List daftar chat (kontak yang pernah chat)
    public function index()
    {
        $userId = Auth::id();

        // Ambil semua pesan dimana user terlibat
        $messages = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Kumpulkan ID user lawan bicara
        $contactIds = $messages->map(function ($message) use ($userId) {
            return $message->sender_id == $userId ? $message->receiver_id : $message->sender_id;
        })->unique();

        // Ambil data user lawan bicara
        $users = User::whereIn('id', $contactIds)->get();

        return view('chat.index', compact('users'));
    }

    // Tampilkan percakapan dengan user tertentu
    public function show($id)
    {
        $otherUser = User::findOrFail($id);
        $myId = Auth::id();

        // Ambil pesan antara saya dan dia
        $messages = Message::where(function ($q) use ($myId, $id) {
            $q->where('sender_id', $myId)->where('receiver_id', $id);
        })->orWhere(function ($q) use ($myId, $id) {
            $q->where('sender_id', $id)->where('receiver_id', $myId);
        })->orderBy('created_at', 'asc')->get();

        // Tandai sebagai terbaca jika saya yang menerima
        Message::where('sender_id', $id)
            ->where('receiver_id', $myId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('chat.show', compact('messages', 'otherUser'));
    }

    // Kirim pesan
    public function store(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $id,
            'message' => $request->message,
        ]);

        return redirect()->route('admin.chat.show', $id);
    }
}
