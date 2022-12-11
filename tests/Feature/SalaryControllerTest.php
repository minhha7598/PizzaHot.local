<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\TestResponse;
use App\Models\Salary;
use Illuminate\Support\Str;

class SalaryControllerTest extends TestCase
{
        //Get all
    public function test_get_all_salary()
    {
        $response = $this->getJson('/api/getAllSalary/')
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data',
                'error'
            ]);
    }
    //Insert
    public function test_insert_salary()
    {
        $response = $this->postJson('/api/insertSalary/', [
            'money' => rand().' 000 VND',
        ])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'True',
                'message' => "Insert salary succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ]);
    }

    //Update
    public function test_update_salary()
    {
        $sample = Salary::create([
            'money' => rand().' 000 VND',
        ]);

        $response = $this->postJson('/api/updateSalary/', [
            'id' => $sample->id,
            'money' => '1 000 VND',
        ])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'True',
                'message' => "Update salary succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ]);
    }

    //Delete
    public function test_delete_salary()
    {
        $sample = Salary::create([
            'money' => rand().' 000 VND',
        ]);

        $response = $this->postJson('/api/deleteSalary/', ['id' => $sample->id])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'True',
                'message' => "Delete salary succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ]);
    }
}