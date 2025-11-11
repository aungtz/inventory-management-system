<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stock;
use Illuminate\Support\Str;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            Stock::create([
                'product_name' => 'Product ' . $i,
                'category' => 'Category ' . rand(1, 5),
                'sku' => 'SKU-' . Str::upper(Str::random(5)),
                'quantity' => rand(0, 50),
                'unit_price' => rand(100, 1000),
                'low_stock' => 5,
            ]);
        }
    }
}
