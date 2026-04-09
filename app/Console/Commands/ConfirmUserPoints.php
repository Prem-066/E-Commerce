<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConfirmUserPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:confirm-user-points';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pendingPoints = DB::table('loyalty_histories')
            ->leftJoin('order_items', 'loyalty_histories.order_item_id', '=', 'order_items.id')
            ->leftJoin('products', 'order_items.product_id', '=', 'products.id')
            ->where('loyalty_histories.status', 'pending')
            ->where('loyalty_histories.type', 'earned')
            ->where('order_items.status', 'Delivered')
            ->select('loyalty_histories.*', 'products.return_policy_days', 'order_items.delivered_at')
            ->get();


        $confirmedCount = 0;
        foreach ($pendingPoints as $history) {
            $days = $history->return_policy_days ?? 7;
            
            $deliveryDate = $history->delivered_at ?: $history->created_at;
            $confirmationDate = \Carbon\Carbon::parse($deliveryDate)->addDays($days);

            if (now()->greaterThanOrEqualTo($confirmationDate)) {

                DB::transaction(function () use ($history) {
                    DB::table('loyalty_histories')
                        ->where('id', $history->id)
                        ->update([
                            'status' => 'completed',
                            'updated_at' => now()
                        ]);

                    DB::table('customers')
                        ->where('id', $history->customer_id)
                        ->increment('loyalty_points', $history->points);
                });
                $confirmedCount++;
            }
        }

        $this->info("Total {$confirmedCount} loyalty points confirmed and added to customer balances.");
    }
}
