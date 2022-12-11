<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Table;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = [
            ['number'=>'1','status'=>'Free', ],
            ['number'=>'2','status'=>'Free', ],
            ['number'=>'3','status'=>'Free', ],
            ['number'=>'4','status'=>'Free', ],
        ];
        Table::insert($table);
    }
}