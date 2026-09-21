<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $ao = Category::create(['name' => 'Áo', 'slug' => 'ao']);
        $quan = Category::create(['name' => 'Quần', 'slug' => 'quan']);
        $phuKien = Category::create(['name' => 'Phụ kiện', 'slug' => 'phu-kien']);

        $products = [
            [$ao, 'Áo thun trắng', 'ao-thun-trang', 150000, 25],
            [$ao, 'Áo sơ mi xanh', 'ao-so-mi-xanh', 280000, 15],
            [$ao, 'Áo khoác gió', 'ao-khoac-gio', 420000, 10],
            [$quan, 'Quần jean nam', 'quan-jean-nam', 350000, 20],
            [$quan, 'Quần short kaki', 'quan-short-kaki', 220000, 30],
            [$phuKien, 'Nón lưỡi trai', 'non-luoi-trai', 90000, 40],
        ];

        foreach ($products as [$category, $name, $slug, $price, $stock]) {
            Product::create([
                'category_id' => $category->id,
                'name' => $name,
                'slug' => $slug,
                'description' => 'Mô tả cho ' . $name,
                'price' => $price,
                'stock' => $stock,
            ]);
        }
    }
}