<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $productIds = Product::pluck('id');
        $colorIds = Color::pluck('id');

        DB::table('product_color')->insert([
            'product_id' => $productIds->random(),
            'color_id' => $colorIds->random(),
        ]);
        DB::table('product_color')->insert([
            'product_id' => $productIds->random(),
            'color_id' => $colorIds->random(),
        ]);
        DB::table('product_color')->insert([
            'product_id' => $productIds->random(),
            'color_id' => $colorIds->random(),
        ]);
        DB::table('product_color')->insert([
            'product_id' => $productIds->random(),
            'color_id' => $colorIds->random(),
        ]);
        DB::table('product_color')->insert([
            'product_id' => $productIds->random(),
            'color_id' => $colorIds->random(),
        ]);
        DB::table('product_color')->insert([
            'product_id' => $productIds->random(),
            'color_id' => $colorIds->random(),
        ]);
        DB::table('product_color')->insert([
            'product_id' => $productIds->random(),
            'color_id' => $colorIds->random(),
        ]);
        DB::table('product_color')->insert([
            'product_id' => $productIds->random(),
            'color_id' => $colorIds->random(),
        ]);
        DB::table('product_color')->insert([
            'product_id' => $productIds->random(),
            'color_id' => $colorIds->random(),
        ]);
        DB::table('product_color')->insert([
            'product_id' => $productIds->random(),
            'color_id' => $colorIds->random(),
        ]);
        DB::table('product_color')->insert([
            'product_id' => $productIds->random(),
            'color_id' => $colorIds->random(),
        ]);
        DB::table('product_color')->insert([
            'product_id' => $productIds->random(),
            'color_id' => $colorIds->random(),
        ]);
        DB::table('product_color')->insert([
            'product_id' => $productIds->random(),
            'color_id' => $colorIds->random(),
        ]);
        DB::table('product_color')->insert([
            'product_id' => $productIds->random(),
            'color_id' => $colorIds->random(),
        ]);
        DB::table('product_color')->insert([
            'product_id' => $productIds->random(),
            'color_id' => $colorIds->random(),
        ]);
        DB::table('product_color')->insert([
            'product_id' => $productIds->random(),
            'color_id' => $colorIds->random(),
        ]);
        DB::table('product_color')->insert([
            'product_id' => $productIds->random(),
            'color_id' => $colorIds->random(),
        ]);
        DB::table('product_color')->insert([
            'product_id' => $productIds->random(),
            'color_id' => $colorIds->random(),
        ]);
        DB::table('product_color')->insert([
            'product_id' => $productIds->random(),
            'color_id' => $colorIds->random(),
        ]);
        DB::table('product_color')->insert([
            'product_id' => $productIds->random(),
            'color_id' => $colorIds->random(),
        ]);
    }
}
