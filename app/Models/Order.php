<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id', 'order_date', 'total', 'ship_order_id', 'table_id'];

    public function shipped_order ()
    {
        return $this->belongsTo(ShippedOrder::class, 'ship_order_id');
    }

    public function table ()
    {
        return $this->belongsTo(Table::class, 'table_id');
    }
}