<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class ProductSheetImport implements ToModel, WithHeadingRow, WithUpserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'product_name'      => $row['product_name'],
            'price'             => $row['price'], 
            'quantity'          => $row['quantity'],
            'photo'             => $row['photo'],
            'discount_code_id'  => $row['discount_code_id'], 
            'category_id'       => $row['category_id'],
            'imported_product_id'       => $row['imported_product_id'],
        ]);
    }
    
    public function uniqueBy()
    {
        return ['product_name', 'price', 'quantity', 'photo', 'discount_code_id', 'category_id','imported_product_id'];
    }
}