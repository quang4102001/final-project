<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizes = ['XS','S', 'M', 'L', 'XL', '2XL', '3XL'];

        foreach ($sizes as $size) {
            DB::table('sizes')->insert(['id' => DB::raw('uuid()'),'name' => $size]);
        }
    }
}
