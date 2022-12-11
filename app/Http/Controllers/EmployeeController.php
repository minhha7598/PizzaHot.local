<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Employee\EmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Http\Requests\IdRequest;
use App\Services\Employee\EmployeeServiceInterface;
use Exception;

class EmployeeController extends Controller
{
    protected $employeeService;
    public function __construct(EmployeeServiceInterface $employeeService)
    {
        $this->employeeService = $employeeService;
    }
    
    //GET-ALL
    public function getAll() 
    { 
        try{
            $employeeAll = $this->employeeService->getAll();
            if(empty($employeeAll->toArray())){
                return response()->json([
                    'status' => 'True',
                    'message' => "Get all employee succesfully! - No employee to get!",
                    'data' => 'No data',
                    'error' => 'False'
                ],200);  
            }
            return response()->json([
                'status' => 'True',
                'message' => "Get all employee succesfully!",
                'data' => $employeeAll,
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Get all employee failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
    //SHOW  
    public function show(IdRequest $request) 
    { 
        try{
            $input = $request->id;
        
            $employeeById = $this->employeeService->show($input);
            
            return response()->json([
                'status' => 'True',
                'message' => "Show employee succesfully!",
                'data' => $employeeById,
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Show employee failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
    //INSERT
    public function insert(EmployeeRequest $request) 
    { 
        try{
            $input = [
                'name' => $request->name,
                'birthdate' => $request->birthdate,
                'address' => $request->address,
                'hiredDate' => $request->hired_date,
                'email' => $request->email,
                'phoneNumber' => $request->phone_number,
                'photo' => $request->photo,
                'departmentId' => $request->department_id,
                'salaryId' => $request->salary_id,
            ];
        
            $this->employeeService->insert($input);
            
            return response()->json([
                'status' => 'True',
                'message' => "Insert employee succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Insert employee failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
    //UPDATE
    public function update(UpdateEmployeeRequest $request) 
    { 
        try{
            $input = [
                'id' => $request->id,
                'name' => $request->name,
                'birthdate' => $request->birthdate,
                'address' => $request->address,
                'hiredDate' => $request->hired_date,
                'email' => $request->email,
                'phoneNumber' => $request->phone_number,
                'photo' => $request->photo,
                'departmentId' => $request->department_id,
                'salaryId' => $request->salary_id,
            ];
        
            $this->employeeService->update($input);

            return response()->json([
                'status' => 'True',
                'message' => "Update employee succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Update employee failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
    //DELETE
    public function destroy(IdRequest $request) 
    { 
        try{
            $input = $request->id;
        
            $this->employeeService->destroy($input);
            
            return response()->json([
                'status' => 'True',
                'message' => "Delete employee succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Delete employee failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
}