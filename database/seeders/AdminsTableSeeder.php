<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $admins = [
            [
                'id' => Str::uuid(),
                'username' => 'adminroot',
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'email' => 'dvquang4102001@gmail.com'
            ]
        ];

        foreach ($admins as $adminData) {
            Admin::create($adminData);
        }
    }
}
