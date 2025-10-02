<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Order::truncate();
        DB::table('order_items')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $users = User::where('role', 'customer')->get();
        $products = Product::all();
        $orderCount = 150; 

        if ($products->isEmpty()) {
            $this->command->info('Tidak ada produk untuk membuat pesanan. Lewati OrderSeeder.');
            return;
        }

        for ($i = 0; $i < $orderCount; $i++) {
            $user = $users->random();
            
            $itemsInOrder = $products->random(rand(1, 4));
            $totalAmount = 0;
            $orderItemsData = [];

            foreach ($itemsInOrder as $product) {
                $quantity = rand(1, 2);
                $subtotal = $product->price * $quantity;
                $totalAmount += $subtotal;
                
                $orderItemsData[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ];
            }
            
            $randomDate = Carbon::now()->subDays(rand(0, 365));

            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $totalAmount,
                'order_code' => 'ORD-' . Str::upper(Str::random(10)) . '-' . Str::upper(Str::random(5)),
                'status' => ['pending', 'success', 'success', 'cancelled', 'failed'][rand(0, 4)],
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ]);

            $order->orderItems()->createMany($orderItemsData);
        }
    }
}
