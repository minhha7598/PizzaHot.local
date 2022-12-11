<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\TestResponse;
use App\Models\Shift;
use Illuminate\Support\Str;

class ShiftControllerTest extends TestCase
{
        //Get all
    public function test_get_all_shift()
    {
        $response = $this->getJson('/api/getAllShift/')
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data',
                'error'
            ]);
    }
    //Insert
    public function test_insert_shift()
    {
        $response = $this->postJson('/api/insertShift/', [
            'name' => Str::random(10),
            'start' => '00:00:00',
            'finish' => '00:00:00',
        ])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'True',
                'message' => "Insert shift succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ]);
    }

    //Update
    public function test_update_shift()
    {
        $sample = Shift::create([
            'name' => Str::random(10),
            'start' => '00:00:00',
            'finish' => '00:00:00',
        ]);
        $response = $this->postJson('/api/updateShift/', [
            'id' => $sample->id,
            'name' => Str::random(10),
        ])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'True',
                'message' => "Update shift succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ]);
    }

    //Delete
    public function test_delete_shift()
    {
        $sample = Shift::create([
            'name' => Str::random(10),
            'start' => '00:00:00',
            'finish' => '00:00:00',
        ]);

        $response = $this->postJson('/api/deleteShift/', ['id' => $sample->id])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'True',
                'message' => "Delete shift succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ]);
    }
}