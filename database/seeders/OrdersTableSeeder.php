<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrdersTableSeeder extends Seeder
{
    private function generateOrderCode()
    {
        $part1 = strtoupper(Str::random(15)); 
        $part2 = strtoupper(Str::random(5));  
        return "ORD-{$part1}-{$part2}";
    }

    public function run()
    {
        $orders = [];
        foreach (range(2, 11) as $userId) {
            $date = Carbon::create(2025, rand(8, 9), rand(1, 28), rand(8, 20), rand(0, 59));
            $orders[] = [
                'user_id' => $userId,
                'total_amount' => rand(100000, 500000),
                'order_code' => $this->generateOrderCode(),
                'created_at' => $date,
                'updated_at' => $date,
            ];
        }

        DB::table('orders')->insert($orders);
    }
}
