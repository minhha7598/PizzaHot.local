<?php

namespace App\Repositories\Ship;

interface ShipRepositoryInterface
{
    public function phoneNumberShippedOrderRecord($phone_number);
    public function iDProductRecord($productId);
    public function idDiscountCodeRecord($productId);
    public function shipOrderIdOrderRecord($shipOrderId);

    //Insert shipped_orders
    public function insertShippedOrder($shipAddress, $phoneNumber);
    
    // Insert orders
    public function insertOrder($totalSum, $shipOrderId);

    //Update products
    public function updateProduct($productId, $restQuantity);
 
    //insert ordered_products
    public function insertOrderedProduct($orderQuantity, $orderPrice, $orderId, $productId);
    
    //Notification
    public function shipNotification($phoneNumber, $shipAddress);

}