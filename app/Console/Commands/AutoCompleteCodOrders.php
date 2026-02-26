<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AutoCompleteCodOrders extends Command
{
    protected $signature = 'orders:auto-complete-cod';
    protected $description = 'Auto-complete COD orders after 3 days without buyer confirmation';

    public function handle()
    {
        $this->info('Checking COD orders for auto-completion...');

        // Get COD orders that are 'processed' and more than 3 days old
        $orders = Order::where('payment_method', 'cod')
            ->where('status', 'processed')
            ->where('created_at', '<=', now()->subDays(3))
            ->whereNull('buyer_confirmed_at')
            ->get();

        if ($orders->isEmpty()) {
            $this->info('No COD orders to auto-complete.');
            return 0;
        }

        $count = 0;
        foreach ($orders as $order) {
            try {
                DB::beginTransaction();

                $order->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                    'seller_confirmed_at' => now(), // Auto-confirmed
                ]);

                // Update payment to success
                DB::table('payments')
                    ->where('order_id', $order->id)
                    ->update([
                        'payment_status' => 'success',
                        'paid_at' => now(),
                    ]);

                DB::commit();
                $count++;
                $this->info("Order {$order->order_code} auto-completed.");
            } catch (\Exception $e) {
                DB::rollBack();
                $this->error("Failed to auto-complete order {$order->order_code}: {$e->getMessage()}");
            }
        }

        $this->info("Successfully auto-completed {$count} COD orders.");
        return 0;
    }
}
