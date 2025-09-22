<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'], // supaya tidak dobel
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'), // password terenkripsi
                'role' => 'admin', // opsional kalau ada kolom role
            ]
        );
    }
}
