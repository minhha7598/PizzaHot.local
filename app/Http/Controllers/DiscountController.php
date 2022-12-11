<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\IdRequest;
use App\Http\Requests\Discount\DiscountRequest;
use App\Http\Requests\Discount\UpdateDiscountRequest;
use App\Services\Discount\DiscountServiceInterface;
use Exception;

class DiscountController extends Controller
{
    protected $discountService;
    public function __construct(DiscountServiceInterface $discountService)
    {
        $this->discountService = $discountService;
    }

    //GET-ALL
    public function getAll() 
    { 
        try{
            $discountAll = $this->discountService->getAll();
            if(empty($discountAll->toArray())){
                return response()->json([
                    'status' => 'True',
                    'message' => "Get all discount succesfully! - No discount to get!",
                    'data' => 'No data',
                    'error' => 'False'
                ],200);  
            }
            return response()->json([
                'status' => 'True',
                'message' => "Get all discount succesfully!",
                'data' => $discountAll,
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Get all discount failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
    
    //INSERT
    public function insert(DiscountRequest $request) 
    { 
        try{
            $input = [
                'id' => $request->id,
                'discountCodeName' => $request->discount_code_name,
                'extendDate' => $request->extend_date,
                'expiredDate' => $request->expired_date,
                'status' => $request->status
            ];
        
            $this->discountService->insert($input);
            
            return response()->json([
                'status' => 'True',
                'message' => "Insert discount succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Insert discount failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
    //UPDATE
    public function update(UpdateDiscountRequest $request) 
    { 
        try{
            $input = [
                'id' => $request->id,
                'discountCodeName' => $request->discount_code_name,
                'extendDate' => $request->extend_date,
                'expiredDate' => $request->expired_date,
                'status' => $request->status
            ];
        
            $this->discountService->update($input);

            return response()->json([
                'status' => 'True',
                'message' => "Update discount succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Update discount failed!",
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
        
            $this->discountService->destroy($input);
            
            return response()->json([
                'status' => 'True',
                'message' => "Delete discount succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Delete discount failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
}