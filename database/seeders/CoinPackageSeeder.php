<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\CoinPackage;

class CoinPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            ['name' => 'Starter Pack', 'coins_amount' => 100, 'price' => 10, 'currency' => 'EGP', 'bonus_coins' => 0, 'sort_order' => 1],
            ['name' => 'Value Pack', 'coins_amount' => 550, 'price' => 50, 'currency' => 'EGP', 'bonus_coins' => 50, 'sort_order' => 2],
            ['name' => 'Popular Pack', 'coins_amount' => 1200, 'price' => 100, 'currency' => 'EGP', 'bonus_coins' => 200, 'sort_order' => 3],
            ['name' => 'Mega Pack', 'coins_amount' => 3000, 'price' => 200, 'currency' => 'EGP', 'bonus_coins' => 1000, 'sort_order' => 4],
        ];

        foreach ($packages as $package) {
            CoinPackage::create($package);
        }
    }
}
