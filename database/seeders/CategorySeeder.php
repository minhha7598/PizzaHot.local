<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = [
            ['category_name'=>'Pizza','description'=>'Hot', ],
            ['category_name'=>'MilkTea','description'=>'Good', ],
            ['category_name'=>'Drink','description'=>'Cold', ],
            ['category_name'=>'Cake','description'=>'Sweet', ],
        ];
        Category::insert($category);
    }
}