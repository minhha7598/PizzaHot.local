<?php

namespace App\Repositories\Bill;

use App\Repositories\Bill\BillRepositoryInterface;
use App\Models\DiscountCode;
use App\Models\ShippedOrder;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderedProduct;
use App\Models\Table;
use Carbon\Carbon;

class BillRepository implements BillRepositoryInterface
{
    public function idOrderRecord($id)
    {
        return Order::Where('id', $id)->first();
    }

    public function orderedProductRecords($id)
    {
        return OrderedProduct::Where('order_id', $id)->get();
    }

    public function productRecord($productId)
    {
        return Product::Where('id', $productId )->first();
    }

    public function dateOrderRecords($from, $to)
    {
        return Order::whereBetween('order_date', [$from, $to]) 
                        ->get(['id', 'order_date', 'total', 'table_id']);
    }

    public function orderIdProductRecord($idProduct)
    {
        return Product::Where('id', $idProduct)->first();
    }
    
    public function discountCodeRecord($discountCodeId)
    {
        return DiscountCode::Where('id', $discountCodeId )->first();
    }
    
    public function shipRecord($shipId)
    {
        return ShippedOrder::Where('id', $shipId )->first();
    }

    public function tableRecord($numberTable)
    {
        return Table::Where('number', $numberTable )->first();
    }

    public function idProducts($id)
    {
        return OrderedProduct::where('order_id', $id)
                                ->orderBy('id')
                                ->get('product_id');
    }
    public function priceQuantityData($id)
    {
        return OrderedProduct::Where('order_id','=',$id)->get(['order_quantity','order_price']); 
    }

    public function iDProductRecord($productId)
    {
        return Product::Where('id', $productId )->first();
    }
    public function orderedProductRecord($id)
    {
        return OrderedProduct::Where('order_id', $id )
                                ->get();
    }

    /* DESTROY */
    //Destroy ship_orders
    public function destroyShipOrder($shipId)
    {
        ShippedOrder::Where('id', $shipId )->delete();
    }

    //Destroy orders
    public function destroyOrder($id)
    {
        Order::Where('ship_order_id', $id )->delete();
    }

    //Destroy ordered_product
    public function destroyOrderProduct($id)
    {
        OrderedProduct::Where('order_id', $id )->delete();
    }
    
    //Update products after destroy ship
    public function updateProductAfterDestroy($productId, $quantityAfterDestroy)
    {
        Product::Where('id', $productId)
            ->update([
                'quantity' => $quantityAfterDestroy,
            ]);
    }

    /* UPDATE */
    //Get new total
    public function getNewOrderQuantity($id)
    {
        return OrderedProduct::Where('order_id', $id )->get(['order_price','order_quantity']);
    }
    //Update new total
    public function updateTotal($id, $updateTotalInput)
    {
        Order::Where('id', $id)
                ->update([
                    'total' => $updateTotalInput.' 000 VND',
                ]);
    }
    //Update order-date
    public function updateOrderDate($id, $orderDate)
    {
        Order::Where('id', $id )
                ->update([
                    'order_date' => $orderDate,
                ]);
    }
    //Update new phone-number
    public function updatePhoneNumber($shipId, $phoneNumber)
    {
        ShippedOrder::Where('id', $shipId )
                ->update([
                    'phone_number' => $phoneNumber,
                ]);
    }
    //Update new address
    public function updateAddress($shipId, $address)
    {
        ShippedOrder::Where('id', $shipId )
                ->update([
                    'ship_address' => $address,
                ]);
    }
    //Update tables
    public function updateTable($numberTable)
    {
        Table::Where('number', $numberTable )
                ->update([
                    'status' => 'Full',
                ]);
    }
    //Reset old tables
    public function resetOldTableId($tableId)
    {
        Table::Where('number', $tableId )
                ->update([
                    'status' => 'Free',
                ]);
    }
    //Update table_id of orders
    public function updateTableId($newTableId, $id)
     {
        Order::Where('id', $id )
                ->update([
                    'table_id' => $newTableId,
                ]);
    }
    //Update product_id of ordered_products
    public function updateProductId($productId, $orderProductId)
    {
        OrderedProduct::Where('id', $orderProductId )
                ->update([
                    'product_id' => $productId,
                ]);
    }
    //Update order_quantity vs order_price
    public function updateOrderQuantityPrice($orderQuantity, $orderPrice, $orderProductId)
    {
        OrderedProduct::Where('id', $orderProductId )
                ->update([
                    'order_quantity' => $orderQuantity,
                    'order_price' => $orderPrice.' 000 VND'
                ]);
    }
    //Update products
    public function updateQuantity($productId, $newQuantity)
    {
        Product::Where('id', $productId )
                ->update([
                    'quantity' => $newQuantity,
                ]);
    }
    
}