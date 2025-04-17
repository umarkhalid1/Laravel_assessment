<?php

namespace Database\Seeders;

use App\Models\Lot;
use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inventories = Inventory::all();

        foreach ($inventories as $inventory) {
            Lot::create([
                'product_id' => $inventory->product_id,
                'lot_number' => 'LOT-' . strtoupper(Str::random(6)),
                'quantity' => $inventory->quantity,
                'price_per_unit' => $inventory->price_per_unit,
                'total_price' => $inventory->quantity * $inventory->price_per_unit,
                'date' => now()->subDays(rand(1, 30))->format('Y-m-d'),
                'location' => 'Warehouse ' . rand(1, 3),
            ]);
        }
    }
}
