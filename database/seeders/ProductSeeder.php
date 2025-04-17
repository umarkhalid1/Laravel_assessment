<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'sku' => 'PRD-001',
                'name' => 'Wireless Mouse',
                'description' => 'Ergonomic wireless mouse with adjustable DPI',
            ],
            [
                'sku' => 'PRD-002',
                'name' => 'Mechanical Keyboard',
                'description' => 'RGB backlit mechanical keyboard with blue switches',
            ],
            [
                'sku' => 'PRD-003',
                'name' => 'USB-C Charger',
                'description' => 'Fast charging USB-C wall charger 30W',
            ],
            [
                'sku' => 'PRD-004',
                'name' => 'HDMI Cable',
                'description' => '2-meter HDMI 2.1 cable for 4K and 8K support',
            ],
            [
                'sku' => 'PRD-005',
                'name' => 'External SSD 1TB',
                'description' => 'Portable solid-state drive with USB 3.2',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
