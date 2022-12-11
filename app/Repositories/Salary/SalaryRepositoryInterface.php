<?php

namespace App\Repositories\Salary;

interface SalaryRepositoryInterface
{
    public function getAll();
    public function insert($input);
    public function update($input);
    public function destroy($input);
}