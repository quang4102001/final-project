<?php

namespace Database\Seeders;

use App\Models\Size;
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
        $data = [
            [
                'name' => 'XS',
                'minHeight' => 130,
                'maxHeight' => 135,
                'minWeight' => 30,
                'maxWeight' => 35,
            ],
            [
                'name' => 'S',
                'minHeight' => 135,
                'maxHeight' => 140,
                'minWeight' => 35,
                'maxWeight' => 40,
            ],
            [
                'name' => 'M',
                'minHeight' => 140,
                'maxHeight' => 145,
                'minWeight' => 40,
                'maxWeight' => 45,
            ],
            [
                'name' => 'L',
                'minHeight' => 145,
                'maxHeight' => 150,
                'minWeight' => 45,
                'maxWeight' => 50,
            ],
            [
                'name' => 'XL',
                'minHeight' => 150,
                'maxHeight' => 155,
                'minWeight' => 50,
                'maxWeight' => 55,
            ],
            [
                'name' => '2XL',
                'minHeight' => 155,
                'maxHeight' => 160,
                'minWeight' => 55,
                'maxWeight' => 60,
            ],
            [
                'name' => '3XL',
                'minHeight' => 160,
                'maxHeight' => 165,
                'minWeight' => 60,
                'maxWeight' => 65,
            ],
            [
                'name' => '4XL',
                'minHeight' => 165,
                'maxHeight' => 170,
                'minWeight' => 65,
                'maxWeight' => 70,
            ],
            [
                'name' => '5XL',
                'minHeight' => 170,
                'maxHeight' => 175,
                'minWeight' => 70,
                'maxWeight' => 75,
            ],
            [
                'name' => '6XL',
                'minHeight' => 175,
                'maxHeight' => 180,
                'minWeight' => 75,
                'maxWeight' => 80,
            ],
            [
                'name' => '7XL',
                'minHeight' => 180,
                'maxHeight' => 185,
                'minWeight' => 80,
                'maxWeight' => 85,
            ],
        ];

        foreach ($data as $row) {
            Size::create([
                'id' => DB::raw('uuid()'),
                'name' => $row['name'],
                'minHeight' => $row['minHeight'],
                'maxHeight' => $row['maxHeight'],
                'minWeight' => $row['minWeight'],
                'maxWeight' => $row['maxWeight']
            ]);
        }
    }
}
