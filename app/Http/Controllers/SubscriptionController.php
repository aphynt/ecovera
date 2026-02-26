<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function index()
    {
        return view('admin.subscription.index');
    }

    public function subscribe(Request $request)
    {
        $user = Auth::user();

        // Midtrans Config
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $orderId = 'SUB-' . now()->timestamp . '-' . $user->id;
        $amount = 30000;

        // Create subscription transaction record
        $subscription = Subscription::create([
            'user_id' => $user->id,
            'order_id' => $orderId,
            'amount' => $amount,
            'status' => 'pending',
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => collect(explode(' ', trim($user->name)))->first(),
                'email' => $user->email,
            ],
            'item_details' => [
                [
                    'id' => 'SUB-1M',
                    'price' => $amount,
                    'quantity' => 1,
                    'name' => 'Langganan Seller 1 Bulan'
                ]
            ]
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Save token
            $subscription->update(['snap_token' => $snapToken]);

            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
