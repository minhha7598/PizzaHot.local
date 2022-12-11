<?php

namespace App\Repositories\Order;

interface OrderRepositoryInterface
{
    public function iDProductRecord($productId);
    public function tableProductRecord($tableId);
    public function idDiscountCodeRecord($discountId);
    public function tableIdOrderRecord($tableId);
    public function insertOrder($insertOrderInput);
    public function updateProduct($updateProductInput);
    public function insertOrderedProduct($OrderedProductInput);
    public function updateTable($tableId);
    public function insertOrderTakeAway($insertOrderInput);
    public function isTakeAwayOrderRecord();
}