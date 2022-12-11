<?php

namespace App\Services\Salary;

use App\Repositories\Salary\SalaryRepositoryInterface;
use App\Services\Salary\SalaryServiceInterface;

class SalaryService implements SalaryServiceInterface
{
    protected $salaryRepository;

    public function __construct(SalaryRepositoryInterface $salaryRepository)
    {
        $this->salaryRepository = $salaryRepository;
    }

    //GET-ALL
    public function getAll()
    {
        $salaryAll = $this->salaryRepository->getAll(); 
        return $salaryAll;
    }
    
    //INSERT
    public function insert($input)
    {
        $this->salaryRepository->insert($input); 
    }
    
    //UPDATE
    public function update($input)
    {
        $this->salaryRepository->update($input); 
    }

    //DESTROY
    public function destroy($input)
    {
        return $this->salaryRepository->destroy($input); 
    }
}