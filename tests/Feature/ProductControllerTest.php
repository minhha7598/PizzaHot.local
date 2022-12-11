<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\TestResponse;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class ProductControllerTest extends TestCase
{
     //Get all
    public function test_get_all_product()
    {
        $response = $this->getJson('/api/getAllProduct/')
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data',
                'error'
            ]);
    }
    //Insert
    public function test_insert_product()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');
        $response = $this->postJson('/api/insertProduct/', [
            'product_name' => Str::random(10),
            'price' => rand().' 000 VND',
            'quantity' => rand(),
            'photo' => $file,
            'discount_code_id' => rand(),
            'category_id' => rand(),
            'imported_product_id' => rand(),
        ])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'True',
                'message' => "Insert product succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ]);
    }

    //Get product by Id
    public function test_get_product_by_id()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');
        $sample = Product::create([
            'product_name' => Str::random(10),
            'price' => rand().' 000 VND',
            'quantity' => rand(),
            'photo' => $file,
            'discount_code_id' => rand(),
            'category_id' => rand(),
            'imported_product_id' => rand(),
        ]);
        $result = [
            'id' => $sample->id,
            'product_name' => $sample->product_name,
            'price' => $sample->price,
            'quantity' => $sample->quantity,
            'photo' => $sample->photo,
            'discount_code_id' => $sample->discount_code_id,
            'category_id' => $sample->category_id,
            'imported_product_id' => $sample->imported_product_id,
        ];
        
        $response = $this->postJson('/api/showProduct/', ['id' => $sample->id])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'True',
                'message' => "Show product succesfully!",
            ]);
    }

    //Update
    public function test_update_product()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');
        $response = $this->postJson('/api/updateProduct/', 
        [
            'id' => '1',
            'product_name' => Str::random(10),
            'price' => rand().' 000 VND',
            'quantity' => rand(),
            'photo' => $file,
            'discount_code_id' => rand(),
            'category_id' => rand(),
            'imported_product_id' => rand(),
        ])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'True',
                'message' => "Update product succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ]);
    }

    //Delete
    public function test_delete_product()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');
        $sample = Product::create([
            'product_name' => Str::random(10),
            'price' => rand().' 000 VND',
            'quantity' => rand(),
            'photo' => $file,
            'discount_code_id' => rand(),
            'category_id' => rand(),
            'imported_product_id' => rand(),
        ]);

        $response = $this->postJson('/api/deleteProduct/', ['id' => $sample->id])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'True',
                'message' => "Delete product succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ]);
    }
}