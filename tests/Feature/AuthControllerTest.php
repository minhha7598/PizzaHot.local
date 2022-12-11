<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class AuthControllerTest extends TestCase
{
    //Register
    public function test_register()
    
    {
        $payload = [
            'user_name' => 'admin',
            'email' => Str::random(10).'@gmail.com',
            'password' => '123',
            'address' => 'ha noi',
            'phone_number' => Str::random(11),
            'is_admin' => '1'
        ];

        $response = $this->postJson('/api/register', $payload);
        $response
            ->assertStatus(200)
            ->assertJson([
                   "status" => "True",
                   "message" => "Register successfully",
            ]);
    }

    public function test_resgister_validate()
    {
        $payload = [
            'user_name' => '',
            'email' => '',
            'password' => '',
            'address' => '',
            'phone_number' => '', 
            'is_admin' => ''
        ];

        $response = $this->postJson('/api/register', $payload);
        $response->assertStatus(422)
                ->assertJsonValidationErrors(
                    ['user_name', 'email', 'password', 'address', 'phone_number', 'is_admin']
                );
    }       

    //Login
    public function test_login()
    {
        //Dont have account
        $payload = ['email' => 'admin@gmail.com','password' => '123' ];

        $response = $this->postJson('/api/login', $payload);
        $response->assertStatus(200);     
    }
    
    public function test_not_exist_login_user_name()
    {
        $this->assertDatabaseHas('users', [
            'email' => 'notuser@gmail.com'
        ]);    
    }

    public function test_login_validate()
    {
        $payload = ['email' => '','password' => '' ];

        $response = $this->postJson('/api/login', $payload);
        $response->assertStatus(422)
                ->assertJsonValidationErrors(
                    ['email', 'password']
                );
    }  
}