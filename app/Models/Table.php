<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id', 'number', 'status'];

    public function orders ()
    {
        return $this->hasMany(Order::class, 'table_id');
    }
}