<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExcelRequest;
use App\Exports\ProductsExport;
use App\Imports\Import;
use Exception;
use Excel;

class ExcelController extends Controller
{
    //IMPORT EXCEL
    public function importExcel (ExcelRequest $request)
    {
        try{
            $import = new Import();
            Excel::import($import, $request->file('file'));
            
            return response()->json([
                'status' => 'True',
                'message' => "Import data succesfully!",    
                'data' => 'No data return',
                'error' => 'False',
            ],200);   
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Import data failed!" ,
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);
        }
    }

    //EXPORT EXCEL
    public function exportExcel ()
    {
        try{
            $productsExport = new ProductsExport();
            return Excel::download($productsExport, 'products.xlsx');
            
            return response()->json([
                'status' => 'True',
                'message' => "Export products succesfully!",    
                'data' => 'No data return',
                'error' => 'False',
            ],200);   
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Export products failed!" ,
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);
        }
    }
}