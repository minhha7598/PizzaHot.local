<?php

namespace App\Services\Order;

use App\Repositories\Order\OrderRepositoryInterface;
use App\Services\Order\OrderServiceInterface;
use Carbon\Carbon;

class OrderService implements OrderServiceInterface
{
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    //Order live
    public function order($input)
    {
        $tableId = $input['tableId'];
        $products = $input['products'];
        
        $totalSum = 0;
        foreach($products as $product) {
            $productId = $product['product_id'];
            $orderQuantity = $product['order_quantity'];
            
            $iDProductRecord = $this->orderRepository->iDProductRecord($productId);
            $price = $iDProductRecord->price;
            $price = (int)$price;
            $discountId = $iDProductRecord->discount_code_id;
            
            //Check discount
            if(isset($discountId)){
                $today = date("Y-m-d");
                $idDiscountCodeRecord = $this->orderRepository->idDiscountCodeRecord($discountId);
                $expiredDate = $idDiscountCodeRecord->expired_date;
                if( strtotime($today) < strtotime($expiredDate))
                {
                    $discount =  $idDiscountCodeRecord->discount_code_name;
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
        $insertOrderInput = [  
            'order_date' => Carbon::now(),
            'total' => ceil($totalSum).' 000 VND',
            'table_id' => $tableId,
        ];
       
        $this->orderRepository->insertOrder($insertOrderInput);
        
        //Complete OrderedProducts
        $tableIdOrderRecord = $this->orderRepository->tableIdOrderRecord($tableId);
        $orderId = $tableIdOrderRecord->id;
        foreach($products as $product) {
            $productId = $product['product_id'];
            $orderQuantity = $product['order_quantity'];
        
            $iDProductRecord = $this->orderRepository->iDProductRecord($productId);
            $price = $iDProductRecord->price;
            $price = (int)$price;
            $discountId = $iDProductRecord->discount_code_id;

            //Check discount
            if(isset($discountId)){
                $today = date("Y-m-d");
                $idDiscountCodeRecord = $this->orderRepository->idDiscountCodeRecord($discountId);
                $expiredDate = $idDiscountCodeRecord->expired_date;
                if( strtotime($today) < strtotime($expiredDate))
                {
                    $discount =  $idDiscountCodeRecord->discount_code_name;
                }else{
                    $discount = 0;
                }
            }else{
                $discount = 0;
            }
            $orderPrice = $price * (1 - $discount/100);

            //insertOrderedProduct
            $OrderedProductInput = [  
                'order_quantity' => $orderQuantity,
                'order_price' => ceil($orderPrice).' 000 VND',
                'order_id' => $orderId,
                'product_id' => $productId
            ];
            $this->orderRepository->insertOrderedProduct($OrderedProductInput);
        }
            
        //Update products
        foreach($products as $product) {
            $productId = $product['product_id'];
            $orderQuantity = $product['order_quantity'];

            $iDProductRecord = $this->orderRepository->iDProductRecord($productId);
            $quantity = $iDProductRecord->quantity;
            $restQuantity = $quantity - $orderQuantity;

            //updateProduct
            $updateProductInput = [
                'productId' => $productId,
                'restQuantity' => $restQuantity,
            ];
            $this->orderRepository->updateProduct($updateProductInput);
        }
        
        //Update tables 
        $this->orderRepository->updateTable($tableId);
    }


    
    //TAKE AWAY
    public function takeAway($input)
    {
        $products = $input['products'];
     
        $totalSum = 0;
        foreach($products as $product) {
            $productId = $product['product_id'];
            $orderQuantity = $product['order_quantity'];
            
            $iDProductRecord = $this->orderRepository->iDProductRecord($productId);
            $price = $iDProductRecord->price;
            $price = (int)$price;
            $discountId = $iDProductRecord->discount_code_id;
            
            //Check discount
            if(isset($discountId)){
                $today = date("Y-m-d");
                $idDiscountCodeRecord = $this->orderRepository->idDiscountCodeRecord($discountId);
                $expiredDate = $idDiscountCodeRecord->expired_date;
                
                if( strtotime($today) < strtotime($expiredDate))
                {
                    $discount =  $idDiscountCodeRecord->discount_code_name;
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
        $insertOrderInput = [  
            'order_date' => Carbon::now(),
            'total' => ceil($totalSum).' 000 VND',
            'is_take_away' => '1',
        ];
        $this->orderRepository->insertOrderTakeAway($insertOrderInput);
        
        //Complete OrderedProducts
        $isTakeAwayOrderRecord = $this->orderRepository->isTakeAwayOrderRecord();
        $orderId = $isTakeAwayOrderRecord->id;
        foreach($products as $product) {
            $productId = $product['product_id'];
            $orderQuantity = $product['order_quantity'];
        
            $iDProductRecord = $this->orderRepository->iDProductRecord($productId);
            $price = $iDProductRecord->price;
            $price = (int)$price;
            $discountId = $iDProductRecord->discount_code_id;

            //Check discount
            if(isset($discountId)){
                $today = date("Y-m-d");
                $idDiscountCodeRecord = $this->orderRepository->idDiscountCodeRecord($discountId);
                $expiredDate = $idDiscountCodeRecord->expired_date;
                if( strtotime($today) < strtotime($expiredDate))
                {
                    $discount =  $idDiscountCodeRecord->discount_code_name;
                }else{
                    $discount = 0;
                }
            }else{
                $discount = 0;
            }
            $orderPrice = $price * (1 - $discount/100);

            //insertOrderedProduct
            $OrderedProductInput = [  
                'order_quantity' => $orderQuantity,
                'order_price' => ceil($orderPrice).' 000 VND',
                'order_id' => $orderId,
                'product_id' => $productId
            ];
            $this->orderRepository->insertOrderedProduct($OrderedProductInput);
        }
            
        //Update products
        foreach($products as $product) {
            $productId = $product['product_id'];
            $orderQuantity = $product['order_quantity'];

            $iDProductRecord = $this->orderRepository->iDProductRecord($productId);
            $quantity = $iDProductRecord->quantity;
            $restQuantity = $quantity - $orderQuantity;

            //updateProduct
            $updateProductInput = [
                'productId' => $productId,
                'restQuantity' => $restQuantity,
            ];
            $this->orderRepository->updateProduct($updateProductInput);
        }
    }
}