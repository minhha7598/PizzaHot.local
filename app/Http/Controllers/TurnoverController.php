<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DateRequest;
use App\Models\Order;
use App\Models\TurnoverDate;
use App\Models\TurnoverMonth;


class TurnoverController extends Controller
{
    //TURNOVER DATE IMPORT
    public function turnoverDateImport (DateRequest $request)
    {
        try{
            $date = $request->date;
            $totalData = Order::WhereDate('order_date', $date)->get('total');      
            
            $turnover = 0;
            foreach($totalData as $val) {
                $turnover+= (int)$val['total'];
            }
    
            TurnoverDate::insert([
                'turnover_date' => $date,
                'turnover' => $turnover.' 000 VND',
            ]);
            return response()->json([
                'status' => 'True',
                'message' => "Imported turnover succesfully!",   
                'data' => 'No data!',
                'error' => 'False',
            ],200);  
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Import turnover failed!" ,
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
 
    //TURNOVER DATE
    public function turnoverDate (DateRequest $request)
    {
        try{
            $date = $request->date;
            $turnover = TurnoverDate::Where('turnover_date', $date)->get('turnover');
            
            if(empty($turnover->toArray())){
                return response()->json([
                    'status' => 'True',
                    'message' => "Get date turnover succesfully!",  
                    'data' => '0 000 VND',
                    'error' => 'False'
                ],200);  
            }
            return response()->json([
                'status' => 'True',
                'message' => "Get date turnover succesfully!",  
                'data' => $turnover ,
                'error' => 'False',
            ],200);  
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Get date turnover failed!" ,
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
    
    //TURNOVER MONTH
    public function turnoverMonth (Request $request)
    {
        try{
            $month = $request->validate([
                'month' => 'required|int',
            ]);
            $turnover = TurnoverDate::whereMonth('turnover_date', $month)->get('turnover');
            
            $turnoverSum = 0;
            foreach($turnover as $val) {
                $turnoverSum += (int)$val['turnover'];
            }
            
            return response()->json([
                'status' => 'True',
                'message' => "Get month turnover succesfully!",   
                'data' => $turnoverSum.' 000 VND',
                'error' => 'False',
            ],200);  
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Get month turnover failed!" ,
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }

    //TOTAL TURNOVER
    public function turnoverTotal ()
    {
        try{
            $total_data = Order::all('total');

            $turnover = 0;
            foreach($total_data as $val) {
                $turnover+= (int)$val['total'];
            }

            return response()->json([
                'status' => 'True',
                'message' => "Get total turnover succesfully!",   
                'data' => $turnover.' 000 VND',
                'error' => 'False',
            ],200);   
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Get total turnover failed!" ,
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);
        }
    }

}