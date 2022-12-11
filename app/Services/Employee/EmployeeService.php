<?php

namespace App\Services\Employee;

use App\Repositories\Employee\EmployeeRepositoryInterface;
use App\Services\Employee\EmployeeServiceInterface;
use Illuminate\Support\Facades\Storage;

class EmployeeService implements EmployeeServiceInterface
{
    protected $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    //GET-ALL
    public function getAll()
    {
        $employeeAll = $this->employeeRepository->getAll(); 
        return $employeeAll;
    }

    //SHOW
    public function show($input)
    {
        $employeeById = $this->employeeRepository->show($input); 
        return $employeeById;
    }
    
    //INSERT
    public function insert($input)
    {
        if(isset($input['photo'])){
            Storage::disk('public')
                    ->put($input['photo']->getClientOriginalName(), file_get_contents($input['photo']));
        }
        $this->employeeRepository->insert($input); 
    }
    
    //UPDATE
    public function update($input)
    {
        $this->employeeRepository->update($input); 
    }

    //DESTROY
    public function destroy($input)
    {
        return $this->employeeRepository->destroy($input); 
    }
}