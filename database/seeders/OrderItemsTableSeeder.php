<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemsTableSeeder extends Seeder
{
    public function run()
    {
        $orders = DB::table('orders')->get();
        $now = Carbon::now();
        $items = [];

        foreach ($orders as $order) {
            // setiap order punya 1-3 item
            $numItems = rand(1, 5);
            for ($i = 0; $i < $numItems; $i++) {
                $quantity = rand(1, 5);
                $price = rand(50000, 500000);
                $subtotal = $quantity * $price;

                $items[] = [
                    'order_id' => $order->id,
                    'product_id' => rand(1, 40), // asumsi ada 20 produk di DB
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                    'created_at' => $order->created_at,
                    'updated_at' => $order->created_at,
                ];
            }
        }

        DB::table('order_items')->insert($items);
    }
}
