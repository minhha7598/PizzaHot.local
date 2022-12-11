<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\Product;
use App\Models\Table;
use App\Models\DiscountCode;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class BillControllerTest extends TestCase
{
    //Order
    public function test_order_live()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');
        $product = Product::create([
            'product_name' => Str::random(10),
            'price' => rand().' 000 VND',
            'quantity' => rand(),
            'photo' => $file,
            'discount_code_id' => null,
            'category_id' => rand(),
            'imported_product_id' => rand(),
        ]);
        $table = Table::create([
            'number' => rand(),
            'status' => 'Free',
        ]);
      
        $response = $this->postJson('/api/orderLive', [
            "table_id" => $table->id,
            "products" => [
                [
                    "product_id" => $product->id,
                    "order_quantity" => "1"   
                ],
            ]
        ]);

        $response->assertStatus(200);  
    }

    //Ship
    public function test_ship_address_validate()
    {
        $payload = [
            "phone_number" => rand(),
            "ship_address" => "",
            "products" => [
                [
                    "product_id" => "1",
                    "order_quantity" => "1"   
                ],
                [
                    "product_id" => "2",
                    "order_quantity" => "2"    
                ]
            ]
        ];

        $response = $this->postJson("/api/ship", $payload);
        $response->assertStatus(422)    
                ->assertJsonValidationErrors(
            [
                "ship_address"
            ]
        );
    }
    
    public function test_ship()
    {
        //Dont have products
        $response = $this->postJson("/api/ship", [
            "phone_number" => "0123456789",
            "ship_address" => "Da Nang",
            "products" => [
                [
                    "product_id" => "1",
                    "order_quantity" => "1"   
                ],
                [
                    "product_id" => "2",
                    "order_quantity" => "2"    
                ]
            ]
        ]);
        
        $response->assertStatus(404)  
                ->assertJson([
                    "status"=> "False",
                    "message"=> "Order failed!",
                    "data" => "No data!",
                    "error" => "True",
                ]);
    }
}