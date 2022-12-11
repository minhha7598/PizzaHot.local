<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderedProduct extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id', 'product_id', 'order_id', 'order_quantity', 'order_price'];

    public function products ()
    {
        return $this->hasMany(Product::class, 'product_id');
    }

    public function orders ()
    {
        return $this->hasMany(Order::class, 'order_id');
    }
}