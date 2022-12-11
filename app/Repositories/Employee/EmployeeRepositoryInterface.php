<?php

namespace App\Repositories\Employee;

interface EmployeeRepositoryInterface
{
    public function getAll();
    public function show($input);
    public function insert($input);
    public function update($request);
    public function destroy($input);
}