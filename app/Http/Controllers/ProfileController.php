<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();

        // Check if buyer, redirect to buyer profile
        if ($user->role === 'buyer') {
            return view('buyer.profile.index');
        }

        // Check if seller, redirect to seller profile
        if ($user->role === 'seller') {
            return view('seller.profile.index');
        }

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

        if ($user->avatar && Storage::disk('public')->exists('profile/' . $user->avatar)) {
            Storage::disk('public')->delete('profile/' . $user->avatar);
        }

        $filename = time() . '_' . $request->avatar->getClientOriginalName();
        $request->avatar->storeAs('profile', $filename, 'public');

        User::where('id', $user->id)->update([
            'avatar' => 'profile/' . $filename
        ]);

        return back()->with('success', 'Avatar berhasil diperbarui.');
    }

    public function myOrders()
    {
        $orders = Order::with(['items.product.primaryImage'])
            ->where('buyer_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $data = [
            'orders' => $orders,
        ];

        return view('buyer.profile.orders', compact('data'));
    }

    public function myAddress()
    {
        $addresses = DB::table('user_addresses')
            ->where('user_id', Auth::id())
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $data = [
            'addresses' => $addresses,
        ];

        return view('buyer.profile.address', compact('data'));
    }

    public function orderDetail($uuid)
    {
        $order = Order::with(['items.product.primaryImage', 'buyer'])
            ->where('uuid', $uuid)
            ->where('buyer_id', Auth::id())
            ->firstOrFail();

        $data = [
            'order' => $order,
        ];

        return view('buyer.profile.order-detail', compact('data'));
    }

    public function orderPayment($uuid)
    {
        $order = Order::where('uuid', $uuid)
            ->where('buyer_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        // Jika sudah ada snap_token, gunakan yang sudah ada
        if ($order->snap_token) {
            $data = [
                'order' => $order,
                'snapToken' => $order->snap_token,
            ];
            return view('buyer.profile.payment', compact('data'));
        }

        // Jika belum ada, buat snap_token baru
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_code,
                'gross_amount' => $order->grand_total,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone,
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Simpan snap_token ke database
            $order->update(['snap_token' => $snapToken]);

            $data = [
                'order' => $order,
                'snapToken' => $snapToken,
            ];

            return view('buyer.profile.payment', compact('data'));
        } catch (\Exception $e) {
            return redirect()->route('buyer.my.orders')->with('error', 'Gagal membuat pembayaran: ' . $e->getMessage());
        }
    }

    public function orderCod($uuid)
    {
        $order = Order::where('uuid', $uuid)->where('buyer_id', Auth::id())->firstOrFail();

        if ($order->status !== 'pending') {
            return redirect()->route('buyer.my.orders')->with('error', 'Pesanan tidak dapat diubah ke COD');
        }

        $order->update([
            'payment_method' => 'cod',
            'status' => 'processing'
        ]);

        return redirect()->route('buyer.my.orders')->with('success', 'Pesanan berhasil dikonfirmasi untuk pembayaran COD');
    }

    public function simulatePay($uuid)
    {
        $order = Order::where('uuid', $uuid)->where('buyer_id', Auth::id())->firstOrFail();

        if ($order->status !== 'pending') {
            return redirect()->route('buyer.my.orders')->with('error', 'Pesanan tidak dapat dibayar');
        }

        // Simulasi pembayaran berhasil (untuk development)
        $order->update([
            'payment_method' => 'midtrans',
            'status' => 'paid',
            'paid_at' => now()
        ]);

        return redirect()->route('buyer.my.orders')->with('success', 'Simulasi pembayaran berhasil! Pesanan sudah berstatus PAID (Mode Development)');
    }

    public function orderCancel(Request $request, $uuid)
    {
        $request->validate([
            'cancel_reason' => 'required|string',
            'cancel_note' => 'nullable|string',
        ]);

        $order = Order::where('uuid', $uuid)
            ->where('buyer_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        $order->update([
            'status' => 'cancelled',
            'cancel_reason' => $request->cancel_reason,
            'cancel_note' => $request->cancel_note,
            'cancelled_at' => now(),
        ]);

        return redirect()->route('buyer.my.orders')
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function orderComplete($uuid)
    {
        $order = Order::where('uuid', $uuid)
            ->where('buyer_id', Auth::id())
            ->where('status', 'shipped')
            ->firstOrFail();

        $order->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return redirect()->route('buyer.my.orders')
            ->with('success', 'Pesanan telah selesai.');
    }

    public function orderReturn(Request $request, $uuid)
    {
        $request->validate([
            'return_reason' => 'required|string',
            'return_description' => 'required|string',
            'return_image' => 'nullable|image|max:2048',
        ]);

        $order = Order::where('uuid', $uuid)
            ->where('buyer_id', Auth::id())
            ->whereIn('status', ['paid', 'completed'])
            ->firstOrFail();

        $imagePath = null;
        if ($request->hasFile('return_image')) {
            $imagePath = $request->file('return_image')->store('returns', 'public');
        }

        // Update order hanya status
        $order->update([
            'status' => 'refunded',
        ]);

        // Simpan detail pengembalian ke tabel returns
        // Ambil order_item_id pertama (atau sesuai kebutuhan)
        $orderItem = $order->items()->first();
        $sellerId = null;
        if ($orderItem) {
            $product = $orderItem->product;
            if ($product && $product->store) {
                $sellerId = $product->store->user_id ?? null;
            }
        }
        // Create return request
        $returnRequest = \App\Models\ReturnRequest::create([
            'order_id' => $order->id,
            'order_item_id' => $orderItem?->id,
            'buyer_id' => Auth::id(),
            'seller_id' => $sellerId,
            'reason' => $request->return_reason,
            'description' => $request->return_description,
            'image' => $imagePath,
            'return_status' => 'requested',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create return_items for each order item
        foreach ($order->items as $item) {
            DB::table('return_items')->insert([
                'uuid' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'return_id' => $returnRequest->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'condition' => 'new',
            ]);
        }

        return redirect()->route('buyer.my.orders')
            ->with('success', 'Pengajuan pengembalian berhasil diajukan. Mohon tunggu konfirmasi admin.');
    }

    public function myReturns()
    {
        $returns = \App\Models\ReturnRequest::with(['order', 'items.product', 'shipment', 'refund', 'seller'])
            ->where('buyer_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        $data = [
            'returns' => $returns,
        ];
        return view('buyer.profile.returns', compact('data'));
    }

    /**
     * Submit shipment tracking for return
     */
    public function submitReturnShipment(Request $request, $uuid)
    {
        $request->validate([
            'courier' => 'required|string|max:100',
            'tracking_number' => 'required|string|max:100',
        ]);

        try {
            DB::beginTransaction();

            $return = \App\Models\ReturnRequest::where('uuid', $uuid)
                ->where('buyer_id', Auth::id())
                ->where('return_status', 'approved')
                ->firstOrFail();

            // Check if shipment already exists
            $existingShipment = \App\Models\ReturnShipment::where('return_id', $return->id)->first();
            if ($existingShipment) {
                // Update existing shipment
                $existingShipment->courier = $request->courier;
                $existingShipment->tracking_number = $request->tracking_number;
                $existingShipment->shipped_at = now();
                $existingShipment->save();
            } else {
                // Create new return shipment using query builder to avoid model issues
                DB::table('return_shipments')->insert([
                    'uuid' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                    'return_id' => $return->id,
                    'courier' => $request->courier,
                    'tracking_number' => $request->tracking_number,
                    'shipped_at' => now(),
                    'received_at' => null,
                ]);
            }

            // Update return status
            $return->return_status = 'item_sent_back';
            $return->save();

            DB::commit();

            return redirect()
                ->route('buyer.my.returns')
                ->with('success', 'Resi pengiriman berhasil disimpan. Silakan tunggu seller menerima barang.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Gagal menyimpan resi: ' . $e->getMessage());
        }
    }
}
