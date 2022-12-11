<?php

namespace App\Repositories\Discount;

use App\Models\DiscountCode;

class DiscountRepository implements DiscountRepositoryInterface
{
    //GET-ALL
    public function getAll()
    {
        $discountAll = DiscountCode::all();
        return $discountAll;
    }

    //INSERT
    public function insert($input)
    {
        DiscountCode::create([
            'discount_code_name' => $input['discountCodeName'],
            'extend_date' => $input['extendDate'],
            'expired_date' => $input['expiredDate'],
            'status' => $input['status'],
        ]);
    }

    //UPDATE
    public function update($input)
    {
        $discountById = DiscountCode::Where('id', '=', $input['id']);
        $odlValue = DiscountCode::Where('id', $input['id'])->first();

        //update
        $discountById->update([
            'discount_code_name' => $input['discountCodeName']?$input['discountCodeName']:$odlValue['discount_code_name'],
            'extend_date' => $input['extendDate']?$input['extendDate']:$odlValue['extend_date'],
            'expired_date' => $input['expiredDate']?$input['expiredDate']:$odlValue['expired_date'],
            'status' => $input['status']?$input['status']:$odlValue['status'],
        ]);
    }

    //DESTROY
    public function destroy($input)
    {
        $discountById = DiscountCode::find($input);
        $discountById->delete();
    }
}