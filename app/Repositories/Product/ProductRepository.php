<?php

namespace App\Repositories\Product;

use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    //GET-ALL
    public function getAll()
    {
        $productAll = Product::all();
        return $productAll;
    }
    
    //SHOW
    public function show($input)
    {
        $productById = Product::find($input);
        return $productById->first();
    }

    //INSERT
    public function insert($input)
    {
        Product::create([
            'product_name' => $input['product_name'],
            'price' => $input['price'],
            'quantity' => $input['quantity'],
            'category_id' => $input['category_id'],
            'photo' => $input['photo']?$input['photo']:false,
            'discount_code_id' => $input['discount_code_id'],
            'imported_product_id' => $input['imported_product_id'],
        ]);
    }

    //UPDATE
    public function update($input)
    {
        $productById = Product::Where('id', '=', $input['id']);
        $odlValue = Product::Where('id', $input['id'])->first();

        //update
        $productById->update([
            'product_name' => $input['product_name']?$input['product_name']:$odlValue['product_name'],
            'price' => $input['price']?$input['price']:$odlValue['price'],
            'quantity' => $input['quantity']?$input['quantity']:$odlValue['quantity'],
            'category_id' => $input['category_id']?$input['category_id']:$odlValue['category_id'],
            'photo' => $input['photo']?$input['photo']:$odlValue['photo'],
            'discount_code_id' => $input['discount_code_id']?$input['discount_code_id']:$odlValue['discount_code_id'],
            'imported_product_id' => $input['imported_product_id']?$input['imported_product_id']:$odlValue['imported_product_id'],
        ]);
    }

    //DESTROY
    public function destroy($input)
    {
        $product = Product::find($input);
        $product->delete();
    }
}