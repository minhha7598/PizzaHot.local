<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id', 'discount_code_name', 'extend_date', 'expired_date','status'];

    public function products ()
    {
        return $this->hasMany(Product::class, 'discount_code_id');
    }
}