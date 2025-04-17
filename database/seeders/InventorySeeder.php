<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        foreach ($products as $product) {
            Inventory::create([
                'product_id'     => $product->id,
                'quantity'       => rand(50, 200),
                // 'price_per_unit' => rand(100, 1000),
                'price_per_unit' => 10
            ]);
        }
    }
}
