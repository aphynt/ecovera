<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Products;

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
    public function show(Request $request, $id)
    {
        $otherUser = User::findOrFail($id);
        $myId = Auth::id();

        $product = null;
        if ($request->has('product_id')) {
            $product = Products::find($request->product_id);
        }

        // Get recent order context if coming from COD
        $recentOrder = null;
        if ($request->has('order_context') || session('cod_success')) {
            $orderItems = DB::table('orders')
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->leftJoin('product_images', function ($join) {
                    $join->on('products.id', '=', 'product_images.product_id')
                        ->where('product_images.is_primary', 1);
                })
                ->where('orders.buyer_id', $myId)
                ->where('order_items.seller_id', $id)
                ->where('orders.created_at', '>=', now()->subHours(1)) // Last hour orders
                ->select(
                    'orders.order_code',
                    'orders.created_at as order_date',
                    'products.name as product_name',
                    'products.price',
                    'product_images.image_url',
                    'order_items.quantity',
                    'order_items.subtotal'
                )
                ->orderBy('orders.created_at', 'desc')
                ->get();

            if ($orderItems->isNotEmpty()) {
                $recentOrder = $orderItems->groupBy('order_code')->first();
            }
        }

        // Ambil pesan antara saya dan dia dengan relasi product dan order
        $messages = Message::with([
            'product.primaryImage',
            'order.orderItems.product.primaryImage'
        ])
            ->where(function ($q) use ($myId, $id) {
                $q->where('sender_id', $myId)->where('receiver_id', $id);
            })->orWhere(function ($q) use ($myId, $id) {
                $q->where('sender_id', $id)->where('receiver_id', $myId);
            })->orderBy('created_at', 'asc')->get();

        // Tandai sebagai terbaca jika saya yang menerima
        Message::where('sender_id', $id)
            ->where('receiver_id', $myId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('chat.show', compact('messages', 'otherUser', 'product', 'recentOrder'));
    }

    // Kirim pesan
    public function store(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $messageData = [
            'sender_id' => Auth::id(),
            'receiver_id' => $id,
            'message' => $request->message,
        ];

        // Add product_id if exists
        if ($request->has('product_id') && $request->product_id) {
            $messageData['product_id'] = $request->product_id;
        }

        Message::create($messageData);

        return redirect()->route('chat.show', $id);
    }
}
