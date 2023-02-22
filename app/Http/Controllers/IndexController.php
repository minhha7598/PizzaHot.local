<?php

namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Pagination\Paginator;
class IndexController extends Controller
{
    public function product()
    {
        try{
            $product = Product::paginate(6);
            return response()->json([
                'status' => 'True',
                'message' => "Get product succesfully!",
                'data' => $product,
                'error' => 'False'
            ],200);
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Get product failed!",
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);
        }
    }
}
