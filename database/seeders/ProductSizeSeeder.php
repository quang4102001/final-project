<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $productIds = Product::pluck('id');
        $sizeIds = Size::pluck('id');

        DB::table('product_size')->insert([
            'product_id' => $productIds->random(),
            'size_id' => $sizeIds->random(),
        ]);
        DB::table('product_size')->insert([
            'product_id' => $productIds->random(),
            'size_id' => $sizeIds->random(),
        ]);
        DB::table('product_size')->insert([
            'product_id' => $productIds->random(),
            'size_id' => $sizeIds->random(),
        ]);
        DB::table('product_size')->insert([
            'product_id' => $productIds->random(),
            'size_id' => $sizeIds->random(),
        ]);
        DB::table('product_size')->insert([
            'product_id' => $productIds->random(),
            'size_id' => $sizeIds->random(),
        ]);
        DB::table('product_size')->insert([
            'product_id' => $productIds->random(),
            'size_id' => $sizeIds->random(),
        ]);
        DB::table('product_size')->insert([
            'product_id' => $productIds->random(),
            'size_id' => $sizeIds->random(),
        ]);
        DB::table('product_size')->insert([
            'product_id' => $productIds->random(),
            'size_id' => $sizeIds->random(),
        ]);
        DB::table('product_size')->insert([
            'product_id' => $productIds->random(),
            'size_id' => $sizeIds->random(),
        ]);
        DB::table('product_size')->insert([
            'product_id' => $productIds->random(),
            'size_id' => $sizeIds->random(),
        ]);
        DB::table('product_size')->insert([
            'product_id' => $productIds->random(),
            'size_id' => $sizeIds->random(),
        ]);
        DB::table('product_size')->insert([
            'product_id' => $productIds->random(),
            'size_id' => $sizeIds->random(),
        ]);
        DB::table('product_size')->insert([
            'product_id' => $productIds->random(),
            'size_id' => $sizeIds->random(),
        ]);
        DB::table('product_size')->insert([
            'product_id' => $productIds->random(),
            'size_id' => $sizeIds->random(),
        ]);
        DB::table('product_size')->insert([
            'product_id' => $productIds->random(),
            'size_id' => $sizeIds->random(),
        ]);
        DB::table('product_size')->insert([
            'product_id' => $productIds->random(),
            'size_id' => $sizeIds->random(),
        ]);
        DB::table('product_size')->insert([
            'product_id' => $productIds->random(),
            'size_id' => $sizeIds->random(),
        ]);
        DB::table('product_size')->insert([
            'product_id' => $productIds->random(),
            'size_id' => $sizeIds->random(),
        ]);
    }
}
