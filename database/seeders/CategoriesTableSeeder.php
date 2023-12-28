<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categories = ['New Arivals', 'Accesories', 'Bag', 'Dressed', 'Jackets', 'Jewelry', 'Shoes', 'Shirts', 'Sweaters', 'T-shirts'];

        foreach ($categories as $category) {
            DB::table('categories')->insert(['id' => DB::raw('uuid()'), 'name' => $category]);
        }
    }
}
