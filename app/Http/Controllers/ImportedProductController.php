<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ImportedProduct\ImportedProductRequest;
use App\Http\Requests\ImportedProduct\UpdateImportedProductRequest;
use App\Http\Requests\IdRequest;
use App\Services\ImportedProduct\ImportedProductServiceInterface;
use Exception;

class ImportedProductController extends Controller
{
    protected $importedProductServie;
    public function __construct(ImportedProductServiceInterface $importedProductServie)
    {
        $this->importedProductServie = $importedProductServie;
    }

    //GET-ALL
    public function getAll() 
    { 
        try{
            $importedProductAll = $this->importedProductServie->getAll();
            if(empty($importedProductAll->toArray())){
                return response()->json([
                    'status' => 'True',
                    'message' => "Get all imported product succesfully! - No imported product to get!",
                    'data' => 'No data',
                    'error' => 'False'
                ],200);  
            }
            return response()->json([
                'status' => 'True',
                'message' => "Get all imported product succesfully!",
                'data' => $importedProductAll,
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Get all imported product failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
    
    //INSERT
    public function insert(ImportedProductRequest $request) 
    { 
        try{
            $input = [
                'cost' => $request->cost,
                'quantity' => $request->quantity,
                'costTotal' => $request->cost_total,
                'date' => $request->date,
            ];
            
            $this->importedProductServie->insert($input);
            
            return response()->json([
                'status' => 'True',
                'message' => "Insert imported product succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Insert imported product failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
    
    //UPDATE
    public function update(UpdateImportedProductRequest $request) 
    { 
        try{
            $input = [
                'id' => $request->id,
                'cost' => $request->cost,
                'quantity' => $request->quantity,
                'costTotal' => $request->cost_total,
                'date' => $request->date,
            ];

            $this->importedProductServie->update($input);

            return response()->json([
                'status' => 'True',
                'message' => "Update imported product succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Update imported product failed!",
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
        
            $this->importedProductServie->destroy($input);
            
            return response()->json([
                'status' => 'True',
                'message' => "Delete imported product succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Delete imported product failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
}