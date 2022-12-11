<?php

namespace App\Services\Shift;

interface ShiftServiceInterface {
    public function getAll();
    public function insert($input);
    public function update($input);
    public function destroy($input);
}