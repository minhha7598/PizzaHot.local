<?php

namespace App\Repositories\ImportedProduct;

use App\Models\ImportedProduct;

class ImportedProductRepository implements ImportedProductRepositoryInterface
{
    //GET-ALL
    public function getAll()
    {
        $importedProductAll = ImportedProduct::all();
        return $importedProductAll;
    }

    //INSERT
    public function insert($input)
    {
        ImportedProduct::create([
            'cost' => $input['cost'],
            'quantity' => $input['quantity'],
            'cost_total' => $input['costTotal'],
            'date' => $input['date'],
        ]);
    }

    //UPDATE
    public function update($input)
    {
        $importedProductById = ImportedProduct::Where('id', '=', $input['id']);
        $odlValue = ImportedProduct::Where('id', $input['id'])->first();
    
        //update
        $importedProductById->update([
            'cost' => $input['cost'],
            'quantity' => $input['quantity'],
            'cost_total' => $input['costTotal'],
            'date' => $input['date']?$input['date']:$odlValue['date'],
        ]);
    }

    //DESTROY
    public function destroy($input)
    {
        $importedProductById = ImportedProduct::find($input);
        $importedProductById->delete();
    }
}