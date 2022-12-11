<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id', 'category_name', 'description'];

    public function products ()
    {
        return $this->hasMany(Product::class);
    }
}