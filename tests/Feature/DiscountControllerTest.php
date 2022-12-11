<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use App\Models\DiscountCode;
use Illuminate\Support\Str;

class DiscountControllerTest extends TestCase
{
       //Get all
       public function test_get_all_category()
       {
           $response = $this->getJson('/api/getAllDiscount/')
               ->assertStatus(200)
               ->assertJsonStructure([
                   'status',
                   'message',
                   'data',
                   'error'
               ]);
       }
       //Insert
       public function test_insert_discount()
       {
           $response = $this->postJson('/api/insertDiscount/', [
                'discount_code_name' => Str::random(10),
                'extend_date' =>'2022-01-01',
                'expired_date' => '2022-01-01',
                'status' => Str::random(10),
            ])
               ->assertStatus(200)
               ->assertJson([
                   'status' => 'True',
                   'message' => "Insert discount succesfully!",
                   'data' => 'No data!',
                   'error' => 'False'
               ]);
       }

    //Update
    public function test_update_discount()
    {
        $sample = DiscountCode::create([
             'discount_code_name' => Str::random(10),
             'extend_date' => '2022-01-01',
             'expired_date' =>'2022-01-01',
             'status' => Str::random(10),
        ]);
         
        $response = $this->postJson('/api/updateDiscount/', [
            'id' =>  $sample->id,
            'discount_code_name' => '100',
        ])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'True',
                'message' => "Update discount succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ]);
    }

    //Delete
    public function test_delete_discount()
    {
        $sample = DiscountCode::create([
            'discount_code_name' => Str::random(10),
            'extend_date' =>'2022-01-01',
            'expired_date' => '2022-01-01',
            'status' => Str::random(10),
        ]);

        $response = $this->postJson('/api/deleteDiscount/', ['id' => $sample->id])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'True',
                'message' => "Delete discount succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ]);
    }
}