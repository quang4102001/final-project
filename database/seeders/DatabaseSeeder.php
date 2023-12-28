<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call(ColorsTableSeeder::class);
        // $this->call(SizesTableSeeder::class);
        // $this->call(CategoriesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        // $this->call(ProductColorSeeder::class);
        // $this->call(ProductSizeSeeder::class);
        // $this->call(AdminsTableSeeder::class);
    }
}
