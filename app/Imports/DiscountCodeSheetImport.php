<?php

namespace App\Imports;

use App\Models\DiscountCode;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;


class DiscountCodeSheetImport implements ToModel,WithHeadingRow, WithUpserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new DiscountCode([
            'discount_code_name'  => $row['discount_code_name'],
            'extend_date'   => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['extend_date'])),
            'expired_date'  => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['expired_date'])),
            'status'  => $row['status'],
        ]);
    }

    public function uniqueBy()
    {
        return ['discount_code_name', 'extend_date', 'expired_date', 'status'];
    }

}