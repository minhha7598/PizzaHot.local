<?php

namespace App\Services\Bill;

use App\Repositories\Bill\BillRepositoryInterface;
use App\Services\Bill\BillServiceInterface;

class BillService implements BillServiceInterface
{
    protected $billRepository;

    public function __construct(BillRepositoryInterface $billRepository)
    {
        $this->billRepository = $billRepository;
    }

    //Get bills by date
    public function billsByDate($date)
    {
        $from = $date.' 00:00:00';
        $to = $date.' 23:59:59';
        $billRecords = $this->billRepository->dateOrderRecords($from, $to);
      
        //Push status to orders SHIP and orders LIVE
        foreach($billRecords as $billRecord){   
            if(isset($billRecord['table_id'])){
                $billRecord['status'] = 'live';
                unset($billRecord['table_id']);
            }else{
                $billRecord['status'] = 'ship';
                unset($billRecord['table_id']);
            }
        }
        return $billRecords;
    }

    //Delete bill
    public function destroy($id)
    {
        $idOrderRecord = $this->billRepository->idOrderRecord($id);
        $shipId = $idOrderRecord->ship_order_id;
        $orderedProductRecords = $this->billRepository->orderedProductRecords($id);
   
        //Check ship-bill or Order-bill ?
        if(isset($shipId)){
            //Update products
            foreach($orderedProductRecords as $orderedProductRecord){
                $productId = $orderedProductRecord->product_id;
                $orderQuantity = $orderedProductRecord->order_quantity;
                
                //Update products after destroy ship
                $productRecord = $this->billRepository->productRecord($productId);
                $quantity = $productRecord->quantity;
                $quantityAfterDestroy = $quantity + $orderQuantity; 
                $this->billRepository->updateProductAfterDestroy($productId, $quantityAfterDestroy);
            }
    
            //Destroy ship_orders
            $this->billRepository->destroyShipOrder($shipId);
    
            //Destroy orders
            $this->billRepository->destroyOrder($id);
    
            //Destroy ordered_products
            $this->billRepository->destroyOrderProduct($id);
        }else{
            //Update products
            foreach($orderedProductRecords as $orderedProductRecord){
                $productId = $orderedProductRecord->product_id;
                $orderQuantity = $orderedProductRecord->order_quantity;
                
                //Update products after destroy ship
                $productRecord = $this->billRepository->productRecord($productId);
                $quantity = $productRecord->quantity;
                $quantityAfterDestroy = $quantity + $orderQuantity; 
                $this->billRepository->updateProductAfterDestroy($productId, $quantityAfterDestroy);
            }
    
            //Destroy orders
            $this->billRepository->destroyOrder($id);
    
            //Destroy ordered_products
            $this->billRepository->destroyOrderProduct($id);
        }
    }

    //Show detail bill
    public function show($id)
    {
        //orders
        $idOrderRecord = $this->billRepository->idOrderRecord($id);
        $shipId = $idOrderRecord->ship_order_id;
        $orderDate = $idOrderRecord->order_date;
        $total = $idOrderRecord->total;
        $tableId = $idOrderRecord->table_id;

        $priceQuantityData = $this->billRepository->priceQuantityData($id);
        $idProducts = $this->billRepository->idProducts($id);

        //Get product_information_array    
        $stackProduct = array();
        $index = 0;
        foreach($idProducts as $idProduct){
            //products
            $orderIdProductRecord = $this->billRepository->orderIdProductRecord($idProduct['product_id']);
            $productName = $orderIdProductRecord->product_name;
            $discountCodeId = $orderIdProductRecord->discount_code_id;     
            
            if(isset($discountCodeId)){
                //discount_codes
                $discountCodeRecord = $this->billRepository->discountCodeRecord($discountCodeId);
                $discountCodeName = $discountCodeRecord->discount_code_name;
                $extendDate = $discountCodeRecord->extend_date;
                $expiredDate = $discountCodeRecord->expired_date;
                $productData = [
                    "product_name" => $productName,
                    "discount_code" => $discountCodeName,
                    "extend_date" => $extendDate,
                    "expired_date" => $expiredDate,
                ];
            }else{
                $productData = [
                    "product_name" => $productName,
                    "discount_code" => 'No discount!',
                ];
            }
                            
            //Boot Pice-quantity   =>  Name
            $nameProduct = collect($productData);
            $mergedProduct = $nameProduct->merge($priceQuantityData[$index]);

            //Boot Name-price-quanity => []
            array_push($stackProduct, $mergedProduct);
            $index++;
        }
        
        //Push date-total => []
        $stackProduct['order_date'] = $orderDate;
        $stackProduct['total'] = $total;
        
        //Check ship-bill or Order-bill or take-away ?
        //Get ships
        if(isset($shipId)){
            $shipRecord = $this->billRepository->shipRecord($shipId);
            $phoneNumber = $shipRecord->phone_number;
            $address = $shipRecord->ship_address;
            
            $stackProduct['phone_number'] = $phoneNumber;
            $stackProduct['address'] = $address;
            $stackProduct['status'] = 'Ship';

        }
        //Get live
        if(isset($tableId)){  
            $tableRecord = $this->billRepository->tableRecord($tableId);
            $tableNumber = $tableRecord->number;

            $stackProduct['table_number'] = $tableNumber;
            $stackProduct['status'] = 'Live';
        }
        //Get take away
        if($idOrderRecord->is_take_away === 1){
            $stackProduct['status'] = 'Take away';
        }
            
        return $stackProduct;
    }

    //Update bill
    public function update($input)
    {
        $id = $input['id'];
        $products = $input['products'];
        $orderDate = $input['orderDate'];
        $phoneNumber = $input['phoneNumber'];
        $address = $input['address'];
        $numberTable = $input['numberTable'];

        $idOrderRecord = $this->billRepository->idOrderRecord($id);
        $shipId = $idOrderRecord->ship_order_id;
        $tableId = $idOrderRecord->table_id;
        $isTakeAway = $idOrderRecord->is_take_away;
   
        //Check ship-bill or live-bill or take-away?
        if(isset($shipId) && !isset($tableId) && $isTakeAway !== 1)
        {   
            //Update ships
            isset($phoneNumber) ? $this->billRepository->updatePhoneNumber($shipId, $phoneNumber) : false;
            isset($address) ? $this->billRepository->updateAddress($shipId, $address) : false;
            
            if(isset($products)){
                $index = 0;
                foreach($products as $product) {
                    $productId = $product['product_id'];
                    $orderQuantity = $product['order_quantity'];
                    
                    $iDProductRecord = $this->billRepository->iDProductRecord($productId);
                    $price = $iDProductRecord->price;
                    $price = (int)$price;
                    $discountCodeId = $iDProductRecord->discount_code_id;
                    $quantity = $iDProductRecord->quantity;
                
                    $orderedProductRecord = $this->billRepository->orderedProductRecord($id);
                    $oldOrderQuantity = $orderedProductRecord[$index]->order_quantity;
                    $orderProductId = $orderedProductRecord[$index]->id;
                    $index++;
                 
                    //Check discount
                    if(isset($orderProductId)){
                        $today = date("Y-m-d");
                        $discountCodeRecord = $this->billRepository->discountCodeRecord($discountCodeId);
                        $expiredDate = $discountCodeRecord->expired_date;
                        if( strtotime($today) < strtotime($expiredDate))
                        {
                            $discount =  $discountCodeRecord->discount_code_name;
                        }else{
                            $discount = 0;
                        }
                    }else{
                        $discount = 0;
                    }
                    $orderPrice = $price * (1 - $discount/100);
               
                    //Update order_products
                    isset($productId) ? $this->billRepository->updateProductId($productId, $orderProductId) : false;
                    isset($orderQuantity) ? $this->billRepository->updateOrderQuantityPrice($orderQuantity, $orderPrice, $orderProductId) : false;

                    //Update products
                    if($oldOrderQuantity < $orderQuantity){
                        $marginQuantity = $orderQuantity - $oldOrderQuantity;
                        $newQuantity = $quantity - $marginQuantity;
                        $this->billRepository->updateQuantity($productId, $newQuantity);
                    }
                    if($oldOrderQuantity > $orderQuantity){
                        $marginQuantity = $oldOrderQuantity - $orderQuantity;
                        $newQuantity = $quantity + $marginQuantity;
                        $this->billRepository->updateQuantity($productId, $newQuantity);
                    }
                }
                
                //Update total of orders
                $newOrderQuantitys = $this->billRepository->getNewOrderQuantity($id);
                $updateTotalInput = 0;
                foreach ($newOrderQuantitys as $newOrderQuantity){
                    $updateTotalInput+=(int)$newOrderQuantity['order_price']*$newOrderQuantity['order_quantity'];
                }
           
                $this->billRepository->updateTotal($id, $updateTotalInput);
            }
            
            //Update order_date of orders
            isset($orderDate) ? $this->billRepository->updateOrderDate($id, $orderDate) : false;
        }

        if(!isset($shipId) && isset($tableId) && $isTakeAway !== 1)
        {   
            if(isset($products)){
                $index = 0;
                foreach($products as $product) {
                    $productId = $product['product_id'];
                    $orderQuantity = $product['order_quantity'];
                    
                    $iDProductRecord = $this->billRepository->iDProductRecord($productId);
                    $price = $iDProductRecord->price;
                    $discountCodeId = $iDProductRecord->discount_code_id;
                    $quantity = $iDProductRecord->quantity;
                
                    $orderedProductRecord = $this->billRepository->orderedProductRecord($id);
                    $oldOrderQuantity = $orderedProductRecord[$index]->order_quantity;
                    $orderProductId = $orderedProductRecord[$index]->id;
                    $index++;
                   
                    //Check discount
                    if(isset($orderProductId)){
                        $today = date("Y-m-d");
                        $discountCodeRecord = $this->billRepository->discountCodeRecord($discountCodeId);
                        $expiredDate = $discountCodeRecord->expired_date;
                        if( strtotime($today) < strtotime($expiredDate))
                        {
                            $discount =  $discountCodeRecord->discount_code_name;
                        }else{
                            $discount = 0;
                        }
                    }else{
                        $discount = 0;
                    }
                    $orderPrice = $price * (1 - $discount/100);
                   
                    //Update order_products
                    isset($productId) ? $this->billRepository->updateProductId($productId, $orderProductId) : false;
                    isset($orderQuantity) ? $this->billRepository->updateOrderQuantityPrice($orderQuantity, $orderPrice, $orderProductId) : false;

                    //Update products
                    if($oldOrderQuantity < $orderQuantity){
                        $marginQuantity = $orderQuantity - $oldOrderQuantity;
                        $newQuantity = $quantity - $marginQuantity;
                        $this->billRepository->updateQuantity($productId, $newQuantity);
                    }
                    if($oldOrderQuantity > $orderQuantity){
                        $marginQuantity = $oldOrderQuantity - $orderQuantity;
                        $newQuantity = $quantity + $marginQuantity;
                        $this->billRepository->updateQuantity($productId, $newQuantity);
                    }
                }
                
                //Update total of orders
                $newOrderQuantitys = $this->billRepository->getNewOrderQuantity($id);
                $updateTotalInput = 0;
                foreach ($newOrderQuantitys as $newOrderQuantity){
                    $updateTotalInput+=$newOrderQuantity['order_price']*$newOrderQuantity['order_quantity'];
                }
           
                $this->billRepository->updateTotal($id, $updateTotalInput);
            }
            
            //Update order_date of orders
            isset($orderDate) ? $this->billRepository->updateOrderDate($id, $orderDate) : false;

            //Update tables - orders
            if(isset($numberTable)){
                //Update new status of tables
                $this->billRepository->updateTable($numberTable);
                //Reset old number of tables
                $this->billRepository->resetOldTableId($tableId);
                
                //Update table_id of orders
                $tableRecord = $this->billRepository->tableRecord($numberTable);
                $newTableId = $tableRecord->id;
                $this->billRepository->updateTableId($newTableId, $id);
            }
        }
        
        if(!isset($shipId) && !isset($tableId) && $isTakeAway === 1)
        {
            if(isset($products)){
                $index = 0;
                foreach($products as $product) {
                    $productId = $product['product_id'];
                    $orderQuantity = $product['order_quantity'];
                    
                    $iDProductRecord = $this->billRepository->iDProductRecord($productId);
                    $price = $iDProductRecord->price;
                    $discountCodeId = $iDProductRecord->discount_code_id;
                    $quantity = $iDProductRecord->quantity;
                
                    $orderedProductRecord = $this->billRepository->orderedProductRecord($id);
                    $oldOrderQuantity = $orderedProductRecord[$index]->order_quantity;
                    $orderProductId = $orderedProductRecord[$index]->id;
                    $index++;
                   
                    //Check discount
                    if(isset($orderProductId)){
                        $today = date("Y-m-d");
                        $discountCodeRecord = $this->billRepository->discountCodeRecord($discountCodeId);
                        $expiredDate = $discountCodeRecord->expired_date;
                        if( strtotime($today) < strtotime($expiredDate))
                        {
                            $discount =  $discountCodeRecord->discount_code_name;
                        }else{
                            $discount = 0;
                        }
                    }else{
                        $discount = 0;
                    }
                    $orderPrice = $price * (1 - $discount/100);
                   
                    //Update order_products
                    isset($productId) ? $this->billRepository->updateProductId($productId, $orderProductId) : false;
                    isset($orderQuantity) ? $this->billRepository->updateOrderQuantityPrice($orderQuantity, $orderPrice, $orderProductId) : false;

                    //Update products
                    if($oldOrderQuantity < $orderQuantity){
                        $marginQuantity = $orderQuantity - $oldOrderQuantity;
                        $newQuantity = $quantity - $marginQuantity;
                        $this->billRepository->updateQuantity($productId, $newQuantity);
                    }
                    if($oldOrderQuantity > $orderQuantity){
                        $marginQuantity = $oldOrderQuantity - $orderQuantity;
                        $newQuantity = $quantity + $marginQuantity;
                        $this->billRepository->updateQuantity($productId, $newQuantity);
                    }
                }
                
                //Update total of orders
                $newOrderQuantitys = $this->billRepository->getNewOrderQuantity($id);
                $updateTotalInput = 0;
                foreach ($newOrderQuantitys as $newOrderQuantity){
                    $updateTotalInput+=$newOrderQuantity['order_price']*$newOrderQuantity['order_quantity'];
                }
           
                $this->billRepository->updateTotal($id, $updateTotalInput);
            }
            
            //Update order_date of orders
            isset($orderDate) ? $this->billRepository->updateOrderDate($id, $orderDate) : false;
        }
         
    }
}