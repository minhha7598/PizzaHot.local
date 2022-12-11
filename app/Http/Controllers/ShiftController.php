<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Shift\ShiftRequest;
use App\Http\Requests\Shift\UpdateShiftRequest;
use App\Http\Requests\IdRequest;
use App\Services\Shift\ShiftServiceInterface;
use Exception;

class ShiftController extends Controller
{
    protected $shiftService;
    public function __construct(ShiftServiceInterface $shiftService)
    {
        $this->shiftService = $shiftService;
    }

    //GET-ALL
    public function getAll() 
    { 
        try{
            $shiftAll = $this->shiftService->getAll();
            if(empty($shiftAll->toArray())){
                return response()->json([
                    'status' => 'True',
                    'message' => "Get all shift succesfully! - No shift to get!",
                    'data' => 'No data',
                    'error' => 'False'
                ],200);  
            }
            return response()->json([
                'status' => 'True',
                'message' => "Get all shift succesfully!",
                'data' => $shiftAll,
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Get all shift failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
    
    //INSERT
    public function insert(ShiftRequest $request) 
    { 
        try{
            $input = [
                'name' => $request->name,
                'start' => $request->start,
                'finish' => $request->finish,
            ];
            
            $this->shiftService->insert($input);
            
            return response()->json([
                'status' => 'True',
                'message' => "Insert shift succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Insert shift failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
    //UPDATE
    public function update(UpdateShiftRequest $request) 
    { 
        try{
            $input = [
                'id' => $request->id,
                'name' => $request->name,
                'start' => $request->start,
                'finish' => $request->finish,
            ];
        
            $this->shiftService->update($input);

            return response()->json([
                'status' => 'True',
                'message' => "Update shift succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Update shift failed!",
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
        
            $this->shiftService->destroy($input);
            
            return response()->json([
                'status' => 'True',
                'message' => "Delete shift succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Delete shift failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
}