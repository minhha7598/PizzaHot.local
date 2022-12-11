<?php

namespace App\Services\Discount;

interface DiscountServiceInterface {
    public function getAll();
    public function insert($input);
    public function update($input);
    public function destroy($input);
}