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
                'sku' => 'Pro1',
                'price' => 19,
                'discounted_price' => 15,
                'category_id' => $CategoryIds->random(),
                'status' => '1'
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Product 2',
                'sku' => 'Pro2',
                'price' => 29,
                'discounted_price' => 25,
                'category_id' => $CategoryIds->random(),
                'status' => '1'
            ],
            [
                'id' => Str::uuid(), // Tạo UUID mới
                'name' => 'Product 3',
                'sku' => 'Pro3',
                'price' => 30,
                'discounted_price' => 15,
                'category_id' => $CategoryIds->random(),
                'status' => '1'
            ],
            [
                'id' => Str::uuid(), // Tạo UUID mới
                'name' => 'Product 5',
                'sku' => 'Pro5',
                'price' => 37,
                'discounted_price' => 17,
                'category_id' => $CategoryIds->random(),
                'status' => '1'
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Product 4',
                'sku' => 'Pro4',
                'price' => 30,
                'discounted_price' => 25,
                'category_id' => $CategoryIds->random(),
                'status' => '1'
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Product 6',
                'sku' => 'Pro6',
                'price' => 37,
                'discounted_price' => 27,
                'category_id' => $CategoryIds->random(),
                'status' => '1'
            ],
            [
                'id' => Str::uuid(), // Tạo UUID mới
                'name' => 'Product 7',
                'sku' => 'Pro7',
                'price' => 19,
                'discounted_price' => 15,
                'category_id' => $CategoryIds->random(),
                'status' => '1'
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Product 8',
                'sku' => 'Pro8',
                'price' => 29,
                'discounted_price' => 25,
                'category_id' => $CategoryIds->random(),
                'status' => '1'
            ],
            [
                'id' => Str::uuid(), // Tạo UUID mới
                'name' => 'Product 9',
                'sku' => 'Pro9',
                'price' => 30,
                'discounted_price' => 15,
                'category_id' => $CategoryIds->random(),
                'status' => '1'
            ],
            [
                'id' => Str::uuid(), // Tạo UUID mới
                'name' => 'Product 10',
                'sku' => 'Pro10',
                'price' => 37,
                'discounted_price' => 17,
                'category_id' => $CategoryIds->random(),
                'status' => '1'
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Product 11',
                'sku' => 'Pro11',
                'price' => 30,
                'discounted_price' => 25,
                'category_id' => $CategoryIds->random(),
                'status' => '1'
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Product 12',
                'sku' => 'Pro12',
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
