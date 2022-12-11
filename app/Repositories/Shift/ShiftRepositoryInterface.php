<?php

namespace App\Repositories\Shift;

interface ShiftRepositoryInterface
{
    public function getAll();
    public function insert($input);
    public function update($input);
    public function destroy($input);
}