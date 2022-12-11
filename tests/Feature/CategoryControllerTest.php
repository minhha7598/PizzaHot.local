<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryControllerTest extends TestCase
{
    //Get all
    public function test_get_all_category()
    {
        $response = $this->getJson('/api/getAllCategory/')
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data',
                'error'
            ]);
    }
    //Insert
    public function test_insert_category()
    {
        $response = $this->postJson('/api/insertCategory/', 
            [
                'category_name' => tr::random(10),
                'description' => Str::random(10),
            ])
        ->assertStatus(200)
        ->assertJson([
            'status' => 'True',
            'message' => "Insert category succesfully!",
            'data' => 'No data!',
            'error' => 'False'
        ]);
    }

    //Update
    public function test_update_category()
    {
        $sample = Category::create([
            'category_name' => Str::random(10),
            'description' => Str::random(10),
        ]);

        $response = $this->postJson('/api/updateCategory/',
            [
                'id' => $sample->id,
                'category_name' => 'Updated',
            ])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'True',
                'message' => "Update category succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ]);
    }

    //Delete
    public function test_delete_category()
    {
        $sample = Category::create([
            'category_name' => Str::random(10),
            'description' => Str::random(10),
        ]);
        $response = $this->postJson('/api/deleteCategory/', ['id' => $sample->id])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'True',
                'message' => "Delete category succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ]);
    }
}