<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Salary\SalaryRequest;
use App\Http\Requests\Salary\UpdateSalaryRequest;
use App\Http\Requests\IdRequest;
use App\Services\Salary\SalaryServiceInterface;
use Exception;

class SalaryController extends Controller
{
    protected $salaryService;
    public function __construct(SalaryServiceInterface $salaryService)
    {
        $this->salaryService = $salaryService;
    }

    //GET-ALL
    public function getAll() 
    { 
        try{
            $salaryAll = $this->salaryService->getAll();
            if(empty($salaryAll->toArray())){
                return response()->json([
                    'status' => 'True',
                    'message' => "Get all salary succesfully! - No salary to get!",
                    'data' => 'No data',
                    'error' => 'False'
                ],200);  
            }
            return response()->json([
                'status' => 'True',
                'message' => "Get all salary succesfully!",
                'data' => $salaryAll,
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Get all salary failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
    
    //INSERT
    public function insert(SalaryRequest $request) 
    { 
        try{
            $input = [
                'money' => $request->money,
            ];
            
            $this->salaryService->insert($input);
            
            return response()->json([
                'status' => 'True',
                'message' => "Insert salary succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Insert salary failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
    //UPDATE
    public function update(UpdateSalaryRequest $request) 
    { 
        try{
            $input = [
                'id' => $request->id,
                'money' => $request->money,
            ];
        
            $this->salaryService->update($input);

            return response()->json([
                'status' => 'True',
                'message' => "Update salary succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Update salary failed!",
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
        
            $this->salaryService->destroy($input);
            
            return response()->json([
                'status' => 'True',
                'message' => "Delete salary succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Delete salary failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
}