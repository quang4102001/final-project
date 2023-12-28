<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = ['#222', '#6e8cd5', '#f56060', '#44c28d', '#ece5d7', '#999999', '#f79858', '#b27ef8', '#f56060', '#ffffff'];

        foreach ($colors as $color) {
            DB::table('colors')->insert(['id' => DB::raw('uuid()'), 'name' => $color]);
        }
    }
}
