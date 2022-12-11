<?php

namespace App\Repositories\Ship;

use App\Repositories\Ship\ShipRepositoryInterface;
use App\Models\DiscountCode;
use App\Models\ShippedOrder;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderedProduct;
use Carbon\Carbon;
use App\Events\Ship;

class ShipRepository implements ShipRepositoryInterface
{
    public function phoneNumberShippedOrderRecord($phone_number)
    {
        return ShippedOrder::Where('phone_number', '=', $phone_number)->get();
    }

    public function iDProductRecord($productId)
    {
        return Product::Where('id', '=',$productId)->first();
    }

    public function idDiscountCodeRecord($discountId)
    {
        return DiscountCode::Where('id', '=',$discountId)->first();
    }

    public function shipOrderIdOrderRecord($shipOrderId)
    {
        return Order::Where('ship_order_id', '=', $shipOrderId )->first();
    }

    //Insert ships
    public function insertShippedOrder($shipAddress, $phoneNumber)
    {
        ShippedOrder::insert([
            'ship_address' => $shipAddress,
            'phone_number' => $phoneNumber,
        ]);  
    }
    
    //Insert orders
    public function insertOrder($totalSum, $shipOrderId)
    {
        Order::insert([
            'order_date' => Carbon::now(),
            'total' => $totalSum.' 000 VND',
            'ship_order_id' => $shipOrderId,
        ]);
    }
    
    //Update products
    public function updateProduct($productId, $restQuantity)
    {
        Product::Where('id', '=', $productId)
        ->update([
            'quantity' => $restQuantity,
        ]);
    }

    //insert OrderedProducts
    public function insertOrderedProduct($orderQuantity, $orderPrice, $orderId, $productId)
    {
        OrderedProduct::insert([
            'order_quantity' => $orderQuantity,
            'order_price' => $orderPrice,
            'order_id' => $orderId,
            'product_id' => $productId,
        ]);
    }
    
    //Event-mail Ship
    public function shipNotification($phoneNumber, $shipAddress)
    {
        Ship::dispatch($phoneNumber, $shipAddress);
    }
}