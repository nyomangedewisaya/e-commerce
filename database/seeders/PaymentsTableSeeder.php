<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentsTableSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lama untuk menghindari duplikat jika seeder dijalankan ulang
        DB::table('payments')->delete();

        $payments = [];
        $methods = ['credit_card', 'bank_transfer', 'e-wallet'];

        // Loop untuk membuat 20 data pembayaran
        foreach (range(1, 20) as $orderId) {
            $payments[] = [
                'order_id' => $orderId,
                // Membuat jumlah pembayaran acak antara 50,000 dan 1,500,000
                'amount' => rand(50000, 1500000),
                // Memilih metode pembayaran secara acak dari array $methods
                'method' => $methods[array_rand($methods)],
                // Membuat nomor invoice acak dengan format INV-XXXXXXXXXX
                'invoice' => 'INV-' . strtoupper(Str::random(10)),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Masukkan semua data ke dalam database dalam satu query
        DB::table('payments')->insert($payments);
    }
}
