<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Models\Product;
use App\Models\DiscountCode;
use App\Models\OrderedProduct;
use App\Models\Table;
use App\Models\Order;
use Carbon\Carbon;

class orderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $products;
    public $tableId;
    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct(OrderRequest $request)
    {
        $this->products = $request->products;
        $this->tableId = $request->table_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tableId = $this->tableId;
        $products = $this->products;
        
        $totalSum = 0;
        foreach($products as $product) {
            $productId = $product['product_id'];
            $orderQuantity = $product['order_quantity'];
            
            $iDProductRecord = Product::Where('id', '=',$productId)->first();
            $price = $iDProductRecord->price;
            $discountId = $iDProductRecord->discount_code_id;
            
            if(isset($discountId)){
                $today = date("Y-m-d");
                $idDiscountCodeRecord =  DiscountCode::Where('id', '=',$discountId)->first();
                $expiredDate = $idDiscountCodeRecord->expired_date;
                if( strtotime($today) < strtotime($expiredDate)){
                    $discount =  DiscountCode::Where('id', '=',$discountId)->first()->discount_code_name;
                }else{
                    $discount = 0;
                }
            }else{
                $discount = 0;
            }
            $orderPrice = $price * (1 - $discount/100);
            
            $total = $orderPrice * $orderQuantity;
            $totalSum+= $total;
        }
        
        //Insert orders
        Order::insert([
            'order_date' => Carbon::now(),
            'total' => $totalSum,
            'table_id' => $tableId,
        ]);  
        
        //Update products
        foreach($products as $product) {
            $productId = $product['product_id'];
            $orderQuantity = $product['order_quantity'];

            $iDProductRecord = Product::Where('id', '=',$productId)->first();
            $quantity = $iDProductRecord->quantity;
            $restQuantity = $quantity - $orderQuantity;

            Product::Where('id', '=', $productId)
                        ->update([
                            'quantity' => $restQuantity,
                        ]);
        }

        //Complete OrderedProducts
        foreach($products as $product) {
            $productId = $product['product_id'];
            $orderQuantity = $product['order_quantity'];
        
            $iDProductRecord = Product::Where('id', '=',$productId)->first();
            $price = $iDProductRecord->price;
            $discountId = $iDProductRecord->discount_code_id;
            $discountIdRecordDiscountCode =  DiscountCode::Where('id', '=',$discountId)->first();
            $orderIdRecordOrder = Order::Where('table_id', '=', $tableId)->first();
            
            if(isset($discountId)){
                $discountId = $idDiscountCodeRecord->discount_code_name;
            }else{
                $discount = 0;
            }
            $orderPrice = $price * (1 - $discount/100);

            $orderId = $orderIdRecordOrder->id;
            OrderedProduct::insert([
                'order_quantity' => $orderQuantity,
                'order_price' => $orderPrice,
                'order_id' => $orderId,
                'product_id' => $productId,
            ]);
        }

        //Update tables 
        Table::Where('id', '=', $tableId)
            ->update([
                'status' => 'Full',
            ]);
    }
}