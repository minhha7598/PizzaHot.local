<?php

namespace App\Services\Ship;

use App\Repositories\Ship\ShipRepositoryInterface;
use App\Services\Ship\ShipServiceInterface;

class ShipService implements ShipServiceInterface
{
    protected $shipRepository;

    public function __construct(ShipRepositoryInterface $shipRepository)
    {
        $this->shipRepository = $shipRepository;
    }

    //Ship
    public function ship($input)
    {
        $products = $input['products'];
        $shipAddress = $input['ship_address'];
        $phoneNumber = $input['phone_number'];
     
        //Insert ship_orders
        $this->shipRepository->insertShippedOrder($shipAddress, $phoneNumber);
        
        //Sum
        $totalSum = 0;
        foreach($products as $product) {
            $productId = $product['product_id'];
            $orderQuantity = $product['order_quantity'];
           
            $iDProductRecord = $this->shipRepository->iDProductRecord($productId);
            $price = $iDProductRecord->price;   
            $price = (int)$price;
            $discountId = $iDProductRecord->discount_code_id;
     
            if(isset($discountId)){
                $today = date("Y-m-d H:i:s");             
                $idDiscountCodeRecord = $this->shipRepository->idDiscountCodeRecord($discountId);
                $expiredDate = $idDiscountCodeRecord->expired_date;
                if( strtotime($today) < strtotime($expiredDate)){
                    $discount = $idDiscountCodeRecord->discount_code_name;
                }else{
                    $discount = 0;
                }
            }else{
                $discount = 0;
            }
            $orderPrice = $price * (1 - $discount/100);   
            $total = $orderPrice * $orderQuantity;
            $totalSum+= $total;
            $totalSum = ceil($totalSum);
        }      
        // Insert orders
        $phoneNumberShippedOrderRecord = $this->shipRepository->phoneNumberShippedOrderRecord($phoneNumber);
        $shipOrderId = $phoneNumberShippedOrderRecord->max('id');
        $this->shipRepository->insertOrder($totalSum, $shipOrderId);

        // Update products
        foreach($products as $product) {
            $productId = $product['product_id'];
            $orderQuantity = $product['order_quantity'];

            $quantity = $iDProductRecord->quantity;
            $restQuantity = $quantity - $orderQuantity;

            $this->shipRepository->updateProduct($productId, $restQuantity);           
        }

        //Complete ordered_products
        foreach($products as $product) {
            $productId = $product['product_id'];
            $orderQuantity = $product['order_quantity'];

            $price = $iDProductRecord->price;
            $price = (int)$price;
            $discountId = $iDProductRecord->discount_code_id;
            $shipOrderIdOrderRecord =  $this->shipRepository->shipOrderIdOrderRecord($shipOrderId);
            $idDiscountCodeRecord =  $this->shipRepository->idDiscountCodeRecord($productId);
            
            if(isset($discountId)){
                $discountId = $idDiscountCodeRecord->discount_code_name;
            }else{
                $discount = 0;
            }
        
            $orderPrice = ceil($price * (1 - $discount/100)).' 000 VND';
            $orderId = $shipOrderIdOrderRecord->id;
            $this->shipRepository->insertOrderedProduct($orderQuantity, $orderPrice, $orderId, $productId);
        }
        
        //Ship Notification
        $this->shipRepository->shipNotification($phoneNumber, $shipAddress);
    }
 
}