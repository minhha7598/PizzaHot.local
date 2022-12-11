<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippedOrder extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id', 'ship_address'];

    public function orders ()
    {
        return $this->hasMany(Order::class, 'ship_order_id');
    }
}