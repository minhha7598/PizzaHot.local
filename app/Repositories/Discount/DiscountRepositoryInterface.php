<?php

namespace App\Repositories\Discount;

interface DiscountRepositoryInterface
{
    public function getAll();
    public function insert($input);
    public function update($request);
    public function destroy($input);
}