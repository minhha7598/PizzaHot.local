<?php

namespace App\Imports;

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class Import implements WithMultipleSheets 
{
   
    public function sheets(): array
    {

        return [
            new DiscountCodeSheetImport(),
            new CategorySheetImport(),
            new ProductSheetImport(),
            new ImportedProductSheetImport(),
            new TableSheetImport(),
            new DepartmentSheetImport(),
            new EmployeeSheetImport(),
            new ShiftSheetImport(),
            new SalarySheetImport(),
        ];
    }
}