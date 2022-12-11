<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class EmployeeSheetImport implements ToModel, WithHeadingRow, WithUpserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Employee([
            'name'          => $row['name'],
            'birthdate'     => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['birthdate'])),
            'address'       => $row['address'],
            'email'       => $row['email'],
            'hired_date'    => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['hired_date'])),
            'phone_number'  => $row['phone_number'],
            'photo'         => $row['photo'], 
            'department_id' => $row['department_id'],
            'salary_id'     => $row['salary_id'], 
        ]);
    }

    public function uniqueBy()
    {
        return ['name', 'birthdate', 'address', 'email', 'hired_date', 'phone_number', 'photo','department_id','salary_id'];
    }
}