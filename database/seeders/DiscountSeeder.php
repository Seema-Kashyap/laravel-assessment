<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Acme\UserDiscounts\Models\Discount;

class DiscountSeeder extends Seeder
{
    public function run(): void
    {
        Discount::create([
            'name' => 'New Year Offer',
            'percentage' => 20,
            'active' => true,
            'expires_at' => now()->addDays(30),
        ]);

        Discount::create([
            'name' => 'Black Friday',
            'percentage' => 50,
            'active' => true,
            'expires_at' => now()->addDays(10),
        ]);

        Discount::create([
            'name' => 'Expired Discount',
            'percentage' => 30,
            'active' => true,
            'expires_at' => now()->subDays(5),
        ]);

        Discount::create([
            'name' => 'Inactive Discount',
            'percentage' => 15,
            'active' => false,
        ]);
    }
}
