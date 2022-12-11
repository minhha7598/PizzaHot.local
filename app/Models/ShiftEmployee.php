<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftEmployee extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id', 'money'];

    public function shifts ()
    {
        return $this->hasMany(Shift::class);
    }

    public function employees ()
    {
        return $this->hasMany(Employee::class);
    }
}