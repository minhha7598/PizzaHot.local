<?php

namespace App\Imports;

use App\Models\ImportedProduct;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class ImportedProductSheetImport implements ToModel, WithHeadingRow, WithUpserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ImportedProduct([
            'cost'        => $row['cost'],
            'quantity'    => $row['quantity'], 
            'cost_total'  => $row['cost_total'],
            'date'        => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date'])),
        ]);
    }

    public function uniqueBy()
    {
        return ['cost', 'quantity', 'cost_total', 'date'];
    }
}