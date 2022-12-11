<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\TestResponse;
use App\Models\ImportedProduct;
use Illuminate\Support\Str;

class ImportedProductControllerTest extends TestCase
{
    //Get all
    public function test_get_all_imported_product()
    {
        $response = $this->getJson('/api/getAllImportedProduct/')
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data',
                'error'
            ]);
    }
    //Insert
    public function test_insert_imported_product()
    {
        $response = $this->postJson('/api/insertImportedProduct/', [
            'cost' => rand().' 000 VND',
            'quantity' => rand(),
            'cost_total' => rand().' 000 VND',
            'date' => '2022-01-01',
        ])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'True',
                'message' => "Insert imported product succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ]);
    }

    //Update
    public function test_update_imported_product()
    {
        $sample = ImportedProduct::create([
            'cost' => Str::random(10),
            'quantity' => rand(),
            'cost_total' => rand().' 000 VND',
            'date' => '2022-01-01',
        ]);
        $response = $this->postJson('/api/updateImportedProduct/', [
            'id' => $sample->id,
            'cost' => $sample->cost,
            'quantity' => $sample->quantity,
            'cost_total' => $sample->cost_total,
            'date' => $sample->date,
        ])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'True',
                'message' => "Update imported product succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ]);
    }

    //Delete
    public function test_delete_imported_product()
    {
        $sample = ImportedProduct::create([
            'cost' => rand().' 000 VND',
            'quantity' => rand(),
            'cost_total' => rand().' 000 VND',
            'date' => '2022-01-01',
        ]);

        $response = $this->postJson('/api/deleteImportedProduct/', ['id' => $sample->id])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'True',
                'message' => "Delete imported product succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ]);
    }
}