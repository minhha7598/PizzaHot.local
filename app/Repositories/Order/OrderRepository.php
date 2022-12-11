<?php

namespace App\Repositories\Order;

use App\Models\Order;
use App\Models\DiscountCode;
use App\Models\Product;
use App\Models\Table;
use App\Models\OrderedProduct;

class OrderRepository implements OrderRepositoryInterface
{
    //iDProductRecord
    public function iDProductRecord($productId)
    {
        return Product::Where('id', '=',$productId)->first();
    }

    //tableProductRecord
    public function tableProductRecord($tableId)
    {
        return Order::Where('id', '=',$tableId)->first();
    }
    
    //idDiscountCodeRecord
    public function idDiscountCodeRecord($discountId)
    {
        return DiscountCode::Where('id', $discountId)->first();
    }

    //tableIdOrderRecord
    public function tableIdOrderRecord($tableId)
    {
        return Order::Where('table_id', '=', $tableId)
                        ->orderBy('id', 'desc')
                        ->first();
    }

    //idDiscountCodeRecord
    public function isTakeAwayOrderRecord()
    {
        return Order::Where('is_take_away', '1')
                            ->orderBy('id', 'desc')
                            ->first();
    }
    
    //insertOrder
    public function insertOrder($insertOrderInput)
    {
        Order::insert([
            'order_date' => $insertOrderInput['order_date'],
            'total' => $insertOrderInput['total'],
            'table_id' => $insertOrderInput['table_id'],
        ]); 
    }

    //insertOrderby take away
    public function insertOrderTakeAway($insertOrderInput)
    {
        Order::insert([
            'order_date' => $insertOrderInput['order_date'],
            'total' => $insertOrderInput['total'],
            'is_take_away' => $insertOrderInput['is_take_away'],
        ]); 
    }
    
    //updateProduct
    public function updateProduct($updateProductInput)
    {
        Product::Where('id', '=', $updateProductInput['productId'])
            ->update([
                'quantity' => $updateProductInput['restQuantity'],
            ]);
    }

    //insertOrderedProduct
    public function insertOrderedProduct($OrderedProductInput)
    {
        OrderedProduct::insert([
            'order_quantity' => $OrderedProductInput['order_quantity'],
            'order_price' => $OrderedProductInput['order_price'],
            'order_id' => $OrderedProductInput['order_id'],
            'product_id' => $OrderedProductInput['product_id'],
        ]);
    }
    
    //updateTable
    public function updateTable($tableId)
    {
        Table::Where('id', $tableId)
            ->update([
                'status' => 'Full',
            ]);
    }
}