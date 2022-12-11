<?php

namespace App\Repositories\Bill;

interface BillRepositoryInterface
{
    //Records
    public function idOrderRecord($id);
    public function orderedProductRecords($id);
    public function productRecord($productId);
    public function dateOrderRecords($from, $to);
    public function orderIdProductRecord($idProduct);
    public function discountCodeRecord($discountCodeId);
    public function shipRecord($shipId);
    public function tableRecord($numberTable);
    public function idProducts($id);
    public function iDProductRecord($productId);
    public function orderedProductRecord($id);
   

    //Destroy ship_orders
    public function destroyShipOrder($shipId);

    //Destroy orders
    public function destroyOrder($id);

    //Destroy ordered_products
    public function destroyOrderProduct($orderId);

    //Update products after destroy ship
    public function updateProductAfterDestroy($productId, $quantityAfterDestroy);

    /*UPDATE*/
    
    //Update ships
    public function updatePhoneNumber($shipId, $phoneNumber);
    public function updateAddress($shipId, $address);
   
    //Update orders
    public function getNewOrderQuantity($id);
    public function updateTotal($id, $updateTotalInput);
    public function updateOrderDate($id, $orderDate);
    public function updateTableId($newTableId, $id);
    
    //Update tables
    public function updateTable($numberTable);
    public function resetOldTableId($tableId);
    
    //Update products
    public function updateQuantity($productId, $newQuantity);

    //Update order_products
    public function updateProductId($productId, $orderProductId);
    public function updateOrderQuantityPrice($orderQuantity, $orderPrice, $orderProductId);
    
}