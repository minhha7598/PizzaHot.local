<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TablePaymentRequest;
use App\Models\Table;
use App\Models\Order;
use App\Models\OrderedProduct;
use App\Models\Product;
use App\Models\DiscountCode;

class PaymentController extends Controller
{
    //PAYMENT
    public function payment(TablePaymentRequest $request)
    {
        try{         
            $tableId = $request->table_id;
            $tableRecord = Table::Where('id','=',$tableId)->first();
            $orderId = Order::Where('table_id','=',$tableId)->max('id');
            $firstOrderedProductRecord = OrderedProduct::Where('order_id','=',$orderId)->first();
            $idFirstRecord = $firstOrderedProductRecord->id;
            
            $firstProdutcId = $firstOrderedProductRecord->product_id;
            $nextProductIds = OrderedProduct::where('id', '>', $idFirstRecord)
                                            ->where('order_id', $orderId)
                                            ->orderBy('id')
                                            ->get('product_id');
           
            $dateTotal = Order::Where('id','=',$orderId)->get(['order_date','total']);
            $priceQuantityData = OrderedProduct::Where('order_id','=',$orderId)->get(['order_quantity','order_price']);     
            
            //Get product_id_array
            $stackProductId = array();
            foreach ($nextProductIds as $nextProductId){
                array_push($stackProductId, $nextProductId['product_id']);
            }         
            $collection = collect($firstProdutcId);
            $idProduct = $collection->merge($stackProductId);
            
            //Get product_information_array    
            $stackProduct = array();
            $index = 0;
            foreach($idProduct as $id){
                $productNameData = Product::Where('id','=',$id)->first()->product_name;
                $productDiscountIdData = Product::Where('id','=',$id)->first()->discount_code_id;
                
                if(isset($productDiscountIdData)){
                    $productDiscountRecord = DiscountCode::Where('id','=', $productDiscountIdData)->first();
                    $productDiscountData = $productDiscountRecord->discount_code_name;
                    $productNameData = [
                        "product_name" => $productNameData,
                        "discount_code" => $productDiscountData,
                    ];
                }else{
                    $productNameData = [
                        "product_name" => $productNameData,
                    ];
                }
                                
                //Boot Pice-quantity   =>  Name
                $nameProduct = collect($productNameData);
                $mergedProduct = $nameProduct->merge($priceQuantityData[$index]);

                //Boot Name-price-quanity => []
                array_push($stackProduct, $mergedProduct);
                $index++;
            }
            //Push date-total => []
            array_push($stackProduct, $dateTotal);
            
            return response()->json([
                'status' => 'True',
                'message' => "Payment processing!",
                'data' => $stackProduct, 
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Payment failed!" ,
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
    
    //CLEAR TABLE
    public function clearTable(TablePaymentRequest $request)
    {
        try{         
            $tableId = $request->table_id;
            $tableRecord = Table::Where('id','=',$tableId)->first();

            //Update table status
            $tableRecord->update(['status' => 'Free']);
            
            return response()->json([
                'status' => 'True',
                'message' => "Clear table successfully!",
                'data' => 'No data!',
                'error' => 'False'
            ],200);      
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Clear table failed!" ,
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
}