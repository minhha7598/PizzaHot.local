<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Requests\IdRequest;
use App\Services\Product\ProductServiceInterface;
use Exception;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    protected $productService;
    
    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    //GET-ALL
    public function getAll()
    {
        try{
            $productAll = $this->productService->getAll();
            if(empty($productAll->toArray())){
                return response()->json([
                    'status' => 'True',
                    'message' => "Get all product succesfully! - No product to get!",
                    'data' => 'No data',
                    'error' => 'False'
                ],200);  
            }
            return response()->json([
                'status' => 'True',
                'message' => "Get all product succesfully!", 
                'data' => $productAll,
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Get all product failed!",
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

            $productById = $this->productService->show($input);
            
            return response()->json([
                'status' => 'True',
                'message' => "Show product succesfully!",
                'data' => $productById,
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Show product failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }

    //INSERT
    public function insert(ProductRequest $request)
    { 
        try{
            $input = [
                'product_name' => $request->product_name,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'category_id' => $request->category_id,
                'photo' => $request->photo,
                'discount_code_id' => $request->discount_code_id,
                'imported_product_id' => $request->imported_product_id,
            ];
            $this->productService->insert($input);
            
            return response()->json([
                'status' => 'True',
                'message' => "Insert product succesfully!",
                'data' => 'No data!',
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Insert product failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
    
    //UPDATE
    public function update(UpdateProductRequest $request)
    {
        try{
            $input = [
                'product_name' => $request->product_name,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'category_id' => $request->category_id,
                'photo' => $request->photo,
                'discount_code_id' => $request->discount_code_id,
                'imported_product_id' => $request->imported_product_id,
                'id' => $request->id,
            ];
           
            $this->productService->update($input);

            return response()->json([
                'status' => 'True',
                'message' => "Update product succesfully!", 
                'data' => 'No data!',
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Update product failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
    
    //DELETE PRODUCT
    public function destroy(IdRequest $request)
    {
        try{
            $input = $request->id;
            
            $this->productService->destroy($input);
            
            return response()->json([
                'status' => 'True',
                'message' => "Delete product succesfully!", 
                'data' => 'No data!',
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Delete product failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
}