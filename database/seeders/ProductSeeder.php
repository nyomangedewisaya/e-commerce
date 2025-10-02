<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $products = [
            ['name' => 'Smartphone G-Pro X1', 'price' => 3500000, 'stock' => 50, 'category' => 'Elektronik'],
            ['name' => 'Laptop UltraBook S14', 'price' => 12500000, 'stock' => 30, 'category' => 'Elektronik'],
            ['name' => 'Wireless Earbuds SoundWave', 'price' => 750000, 'stock' => 100, 'category' => 'Elektronik'],
            ['name' => 'Smartwatch FitTrack 5', 'price' => 1200000, 'stock' => 80, 'category' => 'Elektronik'],
            ['name' => '4K Smart TV 55 Inch', 'price' => 7800000, 'stock' => 20, 'category' => 'Elektronik'],
            ['name' => 'Portable Bluetooth Speaker', 'price' => 450000, 'stock' => 120, 'category' => 'Elektronik'],
            ['name' => 'Gaming Mouse RGB', 'price' => 350000, 'stock' => 150, 'category' => 'Elektronik'],
            ['name' => 'Mechanical Keyboard', 'price' => 950000, 'stock' => 60, 'category' => 'Elektronik'],

            ['name' => 'Kemeja Flanel Lengan Panjang', 'price' => 250000, 'stock' => 100, 'category' => 'Fashion Pria'],
            ['name' => 'Celana Jeans Slim Fit', 'price' => 450000, 'stock' => 80, 'category' => 'Fashion Pria'],
            ['name' => 'Kaos Polos Cotton Combed 30s', 'price' => 85000, 'stock' => 200, 'category' => 'Fashion Pria'],
            ['name' => 'Sepatu Sneakers Canvas', 'price' => 350000, 'stock' => 120, 'category' => 'Fashion Pria'],
            ['name' => 'Jaket Bomber Parasut', 'price' => 320000, 'stock' => 70, 'category' => 'Fashion Pria'],
            ['name' => 'Tas Ransel Laptop', 'price' => 280000, 'stock' => 90, 'category' => 'Fashion Pria'],
            ['name' => 'Dompet Kulit Asli', 'price' => 150000, 'stock' => 150, 'category' => 'Fashion Pria'],
            ['name' => 'Topi Baseball Polos', 'price' => 60000, 'stock' => 300, 'category' => 'Fashion Pria'],
            
            ['name' => 'Blouse Wanita Lengan Balon', 'price' => 180000, 'stock' => 120, 'category' => 'Fashion Wanita'],
            ['name' => 'Rok Plisket Premium', 'price' => 150000, 'stock' => 150, 'category' => 'Fashion Wanita'],
            ['name' => 'Dress Midi Motif Bunga', 'price' => 280000, 'stock' => 90, 'category' => 'Fashion Wanita'],
            ['name' => 'Tas Selempang Wanita', 'price' => 220000, 'stock' => 110, 'category' => 'Fashion Wanita'],
            ['name' => 'Sepatu Heels 5cm', 'price' => 320000, 'stock' => 80, 'category' => 'Fashion Wanita'],
            ['name' => 'Pashmina Ceruty Baby Doll', 'price' => 45000, 'stock' => 400, 'category' => 'Fashion Wanita'],
            ['name' => 'Cardigan Rajut Oversize', 'price' => 135000, 'stock' => 130, 'category' => 'Fashion Wanita'],
            ['name' => 'Celana Kulot High Waist', 'price' => 175000, 'stock' => 100, 'category' => 'Fashion Wanita'],

            ['name' => 'Novel "Bumi Manusia"', 'price' => 125000, 'stock' => 60, 'category' => 'Buku & Majalah'],
            ['name' => 'Buku "Filosofi Teras"', 'price' => 98000, 'stock' => 80, 'category' => 'Buku & Majalah'],
            ['name' => 'Komik "One Piece" Vol. 100', 'price' => 45000, 'stock' => 120, 'category' => 'Buku & Majalah'],
            ['name' => 'Buku Resep Masakan Nusantara', 'price' => 150000, 'stock' => 50, 'category' => 'Buku & Majalah'],
            ['name' => 'Majalah National Geographic', 'price' => 75000, 'stock' => 100, 'category' => 'Buku & Majalah'],
            ['name' => 'Buku "Atomic Habits"', 'price' => 108000, 'stock' => 90, 'category' => 'Buku & Majalah'],

            ['name' => 'Serum Wajah Vitamin C', 'price' => 180000, 'stock' => 100, 'category' => 'Kesehatan & Kecantikan'],
            ['name' => 'Sunscreen SPF 50 PA++++', 'price' => 120000, 'stock' => 150, 'category' => 'Kesehatan & Kecantikan'],
            ['name' => 'Lipstick Matte Nude Series', 'price' => 85000, 'stock' => 200, 'category' => 'Kesehatan & Kecantikan'],
            ['name' => 'Shampo Anti Ketombe', 'price' => 45000, 'stock' => 180, 'category' => 'Kesehatan & Kecantikan'],
            ['name' => 'Suplemen Vitamin D3 1000 IU', 'price' => 95000, 'stock' => 120, 'category' => 'Kesehatan & Kecantikan'],

            ['name' => 'Air Fryer Digital 4L', 'price' => 850000, 'stock' => 50, 'category' => 'Rumah & Dapur'],
            ['name' => 'Set Panci Anti Lengket', 'price' => 450000, 'stock' => 70, 'category' => 'Rumah & Dapur'],
            ['name' => 'Blender Portable USB', 'price' => 250000, 'stock' => 100, 'category' => 'Rumah & Dapur'],
            ['name' => 'Sprei Katun Jepang King Size', 'price' => 350000, 'stock' => 80, 'category' => 'Rumah & Dapur'],

            ['name' => 'Matras Yoga Anti Selip', 'price' => 200000, 'stock' => 90, 'category' => 'Olahraga & Outdoor'],
            ['name' => 'Tali Skipping Digital', 'price' => 150000, 'stock' => 120, 'category' => 'Olahraga & Outdoor'],
            ['name' => 'Botol Minum 2 Liter', 'price' => 80000, 'stock' => 200, 'category' => 'Olahraga & Outdoor'],
            ['name' => 'Sepatu Lari Pria', 'price' => 750000, 'stock' => 60, 'category' => 'Olahraga & Outdoor'],
            ['name' => 'Tenda Camping 4 Orang', 'price' => 650000, 'stock' => 40, 'category' => 'Olahraga & Outdoor'],
        ];

        $categories = Category::pluck('id', 'name');

        foreach ($products as $productData) {
            $productName = $productData['name'];
            Product::create([
                'name' => $productName,
                'slug' => Str::slug($productName),
                'description' => "Deskripsi lengkap untuk {$productName}.",
                'price' => $productData['price'],
                'stock' => $productData['stock'],
                'category_id' => $categories[$productData['category']],
                'image_url' => 'https://placehold.co/300x300/1e293b/94a3b8?text=' . urlencode($productName),
            ]);
        }
    }
}
