<?php

namespace App\Services\Order;

interface OrderServiceInterface {
    public function order($input);
    public function takeAway($input);
}