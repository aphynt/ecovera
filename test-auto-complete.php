<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Test dengan order yang sudah ada
$orderCode = 'ORD-1772109560'; // Ganti dengan order code yang sesuai di database Anda

echo "=== Testing Auto-Complete COD ===\n";
echo "Order Code: {$orderCode}\n\n";

// Cari order
$order = \App\Models\Order::where('order_code', $orderCode)->first();

if (!$order) {
    echo "❌ Order tidak ditemukan!\n";
    exit(1);
}

// Tampilkan info sebelum
echo "📋 INFO SEBELUM:\n";
echo "   Status: {$order->status}\n";
echo "   Payment Method: {$order->payment_method}\n";
echo "   Created At: {$order->created_at}\n";
echo "   Buyer Confirmed: " . ($order->buyer_confirmed_at ? $order->buyer_confirmed_at : 'NULL') . "\n";
echo "   Seller Confirmed: " . ($order->seller_confirmed_at ? $order->seller_confirmed_at : 'NULL') . "\n\n";

// Update created_at menjadi 4 hari lalu
echo "⏰ Mengubah created_at menjadi 4 hari yang lalu...\n";
$order->created_at = now()->subDays(4);
$order->save();
echo "✅ Berhasil! Created at: {$order->created_at}\n\n";

// Jalankan auto-complete
echo "🚀 Menjalankan auto-complete...\n";
echo "=====================================\n";
\Illuminate\Support\Facades\Artisan::call('orders:auto-complete-cod');
echo \Illuminate\Support\Facades\Artisan::output();
echo "=====================================\n\n";

// Cek hasil
$order->refresh();
echo "📋 INFO SETELAH:\n";
echo "   Status: {$order->status}\n";
echo "   Buyer Confirmed: " . ($order->buyer_confirmed_at ? $order->buyer_confirmed_at : 'NULL') . "\n";
echo "   Seller Confirmed: " . ($order->seller_confirmed_at ? $order->seller_confirmed_at : 'NULL') . "\n";
echo "   Completed At: " . ($order->completed_at ? $order->completed_at : 'NULL') . "\n\n";

// Cek payment
$payment = \Illuminate\Support\Facades\DB::table('payments')
    ->where('order_id', $order->id)
    ->first();

if ($payment) {
    echo "💰 PAYMENT INFO:\n";
    echo "   Status: {$payment->payment_status}\n";
    echo "   Paid At: " . ($payment->paid_at ? $payment->paid_at : 'NULL') . "\n\n";
}

if ($order->status === 'completed') {
    echo "✅ TEST BERHASIL! Order sudah auto-completed.\n";
} else {
    echo "❌ TEST GAGAL! Status masih: {$order->status}\n";
}
