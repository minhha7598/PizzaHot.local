<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id', 'name', 'birthdate', 'address', 'email', 'hired_date', 'phone_number', 'photo','department_id','salary_id'];

    public function department ()
    {
        return $this->belongsTo(Department::class, 'discount_code_id');
    }

    public function salary ()
    {
        return $this->belongsTo(Salary::class, 'category_id');
    }

    public function shift_employee ()
    {
        return $this->belongsTo(Shift_employee::class, 'purchased_product_id');
    }
}