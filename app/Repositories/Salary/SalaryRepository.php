<?php

namespace App\Repositories\Salary;

use App\Models\Salary;

class SalaryRepository implements SalaryRepositoryInterface
{
    //GET-ALL
    public function getAll()
    {
        $salaryAll = Salary::all();
        return $salaryAll;
    }

    //INSERT
    public function insert($input)
    {
        Salary::create([
            'money' => $input['money'],
        ]);
    }

    //UPDATE
    public function update($input)
    {
        $salaryById = Salary::Where('id', '=', $input['id']);
        $odlValue = Salary::Where('id', $input['id'])->first();

        //update
        $salaryById->update([
            'money' => $input['money']?$input['money']:$odlValue['money'],
        ]);
    }

    //DESTROY
    public function destroy($input)
    {
        $salaryById = Salary::find($input);
        $salaryById->delete();
    }
}