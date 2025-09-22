<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $customers = [
            ['name' => 'Andi Saputra'],
            ['name' => 'Budi Santoso'],
            ['name' => 'Citra Lestari'],
            ['name' => 'Dewi Anggraini'],
            ['name' => 'Eko Prasetyo'],
            ['name' => 'Fitri Handayani'],
            ['name' => 'Gilang Permana'],
            ['name' => 'Hani Ramadhani'],
            ['name' => 'Indra Wijaya'],
            ['name' => 'Joko Susilo'],
        ];

        foreach ($customers as $customer) {
            $firstName = explode(' ', $customer['name'])[0]; // ambil nama depan
            $email = Str::lower($firstName) . '@gmail.com';
            $password = Hash::make($firstName . '123');

            DB::table('users')->insert([
                'name' => $customer['name'],
                'email' => $email,
                'password' => $password,
                'role' => 'customer',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
