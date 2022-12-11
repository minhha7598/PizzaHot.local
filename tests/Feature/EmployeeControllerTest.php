<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class EmployeeControllerTest extends TestCase
{
    //Get all
    public function test_get_all_employee()
    {
        $response = $this->getJson('/api/getAllEmployee/')
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data',
                'error'
            ]);
    }
    //Insert
    public function test_insert_employee()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');
        
        $response = $this->postJson('/api/insertEmployee/', [
            'name' => Str::random(10),
            'birthdate' => '2022-01-01',
            'address' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'hired_date' => '2022-01-01',
            'phone_number' => '0905111222',
            'photo' => $file,
            'department_id' => rand(),
            'salary_id' => rand(),
        ])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'True',
                'message' => "Insert employee succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ]);
        // Storage::disk('public')->assertExists($file->hashName());
    }

    //Get employee by Id
    public function test_get_employee_by_id()
    {
        $sample = Employee::create([
            'name' => Str::random(10),
            'birthdate' => '2022-01-01',
            'address' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'hired_date' => '2022-01-01',
            'phone_number' => rand(),
            'photo' => Str::random(10),
            'department_id' => rand(),
            'salary_id' => rand(),
        ]);
        
        $response = $this->postJson('/api/showEmployee/', ['id' => $sample->id])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'True',
                'message' => "Show employee succesfully!",
            ]);
    }

    //Update
    public function test_update_employee()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');
        $response = $this->postJson('/api/updateEmployee/', [
            'id' => '1',
            'name' => Str::random(10),
            'birthdate' => '2022-01-01',
            'address' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'hired_date' => '2022-01-01',
            'phone_number' => '0905111222',
            'photo' => $file,
            'department_id' => rand(),
            'salary_id' => rand(),
        ])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'True',
                'message' => "Update employee succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ]);
    }

    //Delete
    public function test_delete_employee()
    {
        $sample = Employee::create([
            'name' => Str::random(10),
            'birthdate' => '2022-01-01',
            'address' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'hired_date' => '2022-01-01',
            'phone_number' => rand(),
            'photo' => Str::random(10),
            'department_id' => rand(),
            'salary_id' => rand(),
        ]);
        
        $response = $this->postJson('/api/deleteEmployee/', ['id' => $sample->id])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'True',
                'message' => "Delete employee succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ]);
    }
}