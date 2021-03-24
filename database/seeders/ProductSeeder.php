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
     * @return void
     */
    public function run()
    {
        Product::truncate();
        
        Product::create([
            'name' => 'Sabão em pó',
            'type' => 'Limpeza',
            'quantity' => 5
        ]);
        Product::create([
            'name' => 'Sabão líquido',
            'type' => 'Higiene',
            'quantity' => 2
        ]);
    }
}
