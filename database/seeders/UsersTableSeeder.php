<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder 
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'okta@gmail.com'], // supaya tidak dobel
            [
                'name' => 'Okta Ferdian',
                'password' => Hash::make('okta1234'), // password terenkripsi
                'role' => 'customer', // opsional kalau ada kolom role
            ]
        );
    }
}
