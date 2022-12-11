<?php

namespace App\Services\Salary;

interface SalaryServiceInterface {
    public function getAll();
    public function insert($input);
    public function update($input);
    public function destroy($input);
}