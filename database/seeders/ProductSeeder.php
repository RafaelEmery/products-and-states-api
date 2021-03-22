<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * TODO: Insert multiple products
     *
     * @return void
     */
    public function run()
    {
        Product::truncate();
        
        Product::create([
            'name' => 'Sabão em pó',
            'type' => 'Limpeza',
            'quantity' => '5'
        ]);
        Product::create([
            'name' => 'Arroz',
            'type' => 'Cesta básica',
            'quantity' => '15'
        ]);
    }
}
