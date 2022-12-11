<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = [
            ['product_name'=>'Pizza_SeaFood','price'=>'15000','quantity'=>'600','category_id'=>'1' ],
            ['product_name'=>'Pizza_Mixed','price'=>'27000','quantity'=>'500','category_id'=>'1' ],
            ['product_name'=>'Pizza_Tomato','price'=>'62000','quantity'=>'750','category_id'=>'3' ],
            ['product_name'=>'Pizza_Eggplant','price'=>'45000','quantity'=>'1000','category_id'=>'2' ],
        ];
        Product::insert($product);
    }
}