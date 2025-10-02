<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Payment::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $orders = Order::all();
        $paymentMethods = ['e-wallet', 'bank_transfer', 'credit_card'];

        foreach ($orders as $order) {
            Payment::create([
                'order_id' => $order->id,
                'amount' => $order->total_amount,
                'method' => $paymentMethods[array_rand($paymentMethods)],
                'invoice' => 'INV-' . Str::upper(Str::random(10)) . '-' . Str::upper(Str::random(5)),
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
            ]);
        }
    }
}
