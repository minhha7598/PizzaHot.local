<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Category\CategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Requests\IdRequest;
use App\Services\Category\CategoryServiceInterface;
use Exception;

class CategoryController extends Controller
{
    protected $categoryService;
    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    
    //GET-ALL
    public function getAll() 
    { 
        try{
            $categoryAll = $this->categoryService->getAll();
        
            if(empty($categoryAll->toArray())){
                return response()->json([
                    'status' => 'True',
                    'message' => "Get all category succesfully! - No category to get!",
                    'data' => 'No data',
                    'error' => 'False'
                ],200);  
            }
            return response()->json([
                'status' => 'True',
                'message' => "Get all category succesfully!",
                'data' => $categoryAll,
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Get all category failed!",
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
        
            $categoryById = $this->categoryService->show($input);
            
            return response()->json([
                'status' => 'True',
                'message' => "Show category succesfully!",
                'data' => $categoryById,
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Show category failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
    //INSERT
    public function insert(CategoryRequest $request) 
    { 
        try{
            $input = [
                'category_name' => $request->category_name,
                'description' => $request->description
            ];
        
            $this->categoryService->insert($input);
            
            return response()->json([
                'status' => 'True',
                'message' => "Insert category succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Insert category failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
    //UPDATE
    public function update(UpdateCategoryRequest $request) 
    { 
        try{
            $input = [
                'category_name' => $request->category_name,
                'description' => $request->description,
                'id' => $request->id
            ];
        
            $this->categoryService->update($input);

            return response()->json([
                'status' => 'True',
                'message' => "Update category succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Update category failed!",
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
        
            $this->categoryService->destroy($input);
            
            return response()->json([
                'status' => 'True',
                'message' => "Delete category succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Delete category failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
}