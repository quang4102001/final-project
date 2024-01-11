<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $CategoryIds = Category::pluck('id');
        // Thêm dữ liệu mẫu
        $products = [
            [
                'id' => Str::uuid(), // Tạo UUID mới
                'name' => 'Product 1',
                'sku' => 'P1',
                'price' => 19,
                'discounted_price' => 15,
                'category_id' => $CategoryIds->random(),
                'status' => '1'
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Product 2',
                'sku' => 'P2',
                'price' => 29,
                'discounted_price' => 25,
                'category_id' => $CategoryIds->random(),
                'status' => '1'
            ],
            [
                'id' => Str::uuid(), // Tạo UUID mới
                'name' => 'Product 3',
                'sku' => 'P3',
                'price' => 30,
                'discounted_price' => 15,
                'category_id' => $CategoryIds->random(),
                'status' => '1'
            ],
            [
                'id' => Str::uuid(), // Tạo UUID mới
                'name' => 'Product 5',
                'sku' => 'P3',
                'price' => 37,
                'discounted_price' => 17,
                'category_id' => $CategoryIds->random(),
                'status' => '1'
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Product 4',
                'sku' => 'P4',
                'price' => 30,
                'discounted_price' => 25,
                'category_id' => $CategoryIds->random(),
                'status' => '1'
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Product 6',
                'sku' => 'P4',
                'price' => 37,
                'discounted_price' => 27,
                'category_id' => $CategoryIds->random(),
                'status' => '1'
            ],
            [
                'id' => Str::uuid(), // Tạo UUID mới
                'name' => 'Product 1',
                'sku' => 'P1',
                'price' => 19,
                'discounted_price' => 15,
                'category_id' => $CategoryIds->random(),
                'status' => '1'
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Product 2',
                'sku' => 'P2',
                'price' => 29,
                'discounted_price' => 25,
                'category_id' => $CategoryIds->random(),
                'status' => '1'
            ],
            [
                'id' => Str::uuid(), // Tạo UUID mới
                'name' => 'Product 3',
                'sku' => 'P3',
                'price' => 30,
                'discounted_price' => 15,
                'category_id' => $CategoryIds->random(),
                'status' => '1'
            ],
            [
                'id' => Str::uuid(), // Tạo UUID mới
                'name' => 'Product 5',
                'sku' => 'P3',
                'price' => 37,
                'discounted_price' => 17,
                'category_id' => $CategoryIds->random(),
                'status' => '1'
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Product 4',
                'sku' => 'P4',
                'price' => 30,
                'discounted_price' => 25,
                'category_id' => $CategoryIds->random(),
                'status' => '1'
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Product 6',
                'sku' => 'P4',
                'price' => 37,
                'discounted_price' => 27,
                'category_id' => $CategoryIds->random(),
                'status' => '1'
            ],
            // Thêm nhiều sản phẩm khác nếu cần
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
