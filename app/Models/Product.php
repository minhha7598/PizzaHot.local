<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id', 'product_name', 'price', 'quantity', 'photo', 'discount_code_id', 'category_id','imported_product_id'];

    public function discount_code ()
    {
        return $this->belongsTo(DiscountCode::class, 'discount_code_id');
    }

    public function category ()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function imported_product ()
    {
        return $this->belongsTo(ImportedProduct::class, 'imported_product_id');
    }

    public function ordered_product ()
    {
        return $this->belongsTo(Order::class, 'product_id');
    }
}