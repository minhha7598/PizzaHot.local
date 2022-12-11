<?php

namespace App\Repositories\Employee;

use App\Models\Employee;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    //GET-ALL
    public function getAll()
    {
        $employeeAll = Employee::all(['name','birthdate','address','department_id','salary_id']);
        return $employeeAll;
    }
   
    //SHOW
    public function show($input)    
    {
        $employeeById = Employee::Where('id', $input);
        return $employeeById->first();
    }

    //INSERT
    public function insert($input)
    {
        Employee::create([
            'name' => $input['name'],
            'birthdate' => $input['birthdate'],
            'address' => $input['address'],
            'hired_date' => $input['hiredDate'],
            'email' => $input['email'],
            'phone_number' => $input['phoneNumber'],
            'photo' => $input['photo'],
            'department_id' => $input['departmentId'],
            'salary_id' => $input['salaryId']
        ]);
    }

    //UPDATE
    public function update($input)
    {
        $employeeById = Employee::Where('id', '=', $input['id']);
        $odlValue = Employee::Where('id', $input['id'])->first();

        //update
        $employeeById->update([
            'name' => $input['name']?$input['name']:$odlValue['name'],
            'birthdate' => $input['birthdate']?$input['birthdate']:$odlValue['birthdate'],
            'address' => $input['address']?$input['address']:$odlValue['address'],
            'hired_date' => $input['hiredDate']?$input['hiredDate']:$odlValue['hired_date'],
            'email' => $input['email']?$input['email']:$odlValue['email'],
            'phone_number' => $input['phoneNumber']?$input['phoneNumber']:$odlValue['phone_number'],
            'photo' => $input['photo']?$input['photo']:$odlValue['photo'],
            'department_id' => $input['departmentId']?$input['departmentId']:$odlValue['department_id'],
            'salary_id' => $input['salaryId']?$input['salaryId']:$odlValue['salary_id'],
        ]);
    }

    //DESTROY
    public function destroy($input)
    {
        $employeeById = Employee::find($input);
        $employeeById->delete();
    }
}