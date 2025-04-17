<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PricingRuleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pricing_rules')->insert([
            [
                'type' => 'quantity_based',
                'discount_type' => 'discount',
                'discount_value' => 5.00, 
                'min_quantity' => 10,
                'day_of_week' => null,
                'precedence' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'type' => 'time_based',
                'discount_type' => 'discount',
                'discount_value' => 15.00, 
                'min_quantity' => null,
                'day_of_week' => 'saturday',
                'precedence' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}