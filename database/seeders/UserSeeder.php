<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            ['user_name'=>'minhhung','name'=>'Hung','email'=>'hungminhha751998@gmail.com','password'=>'password','address'=>'Da Nang','phone_number'=>'0905123456','is_admin'=>'0'],
        ];
        User::insert($user);
    }
}
