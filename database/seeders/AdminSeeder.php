<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@couponx.com'],
            [
                'name' => 'CouponX Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('Admin@123'),
                'phone' => '01000000000',
                'is_admin' => true,
                'is_verified' => true,
                'coins_balance' => 1000000,
            ]
        );
    }
}
