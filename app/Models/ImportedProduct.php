<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportedProduct extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id', 'cost', 'quantity', 'cost_total','date'];

    public function product ()
    {
        return $this->hasOne(Product::class, 'imported_product_id');
    }
}