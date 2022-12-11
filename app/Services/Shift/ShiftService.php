<?php

namespace App\Services\Shift;

use App\Repositories\Shift\ShiftRepositoryInterface;
use App\Services\Shift\ShiftServiceInterface;

class ShiftService implements ShiftServiceInterface
{
    protected $shiftRepository;

    public function __construct(ShiftRepositoryInterface $shiftRepository)
    {
        $this->shiftRepository = $shiftRepository;
    }

    //GET-ALL
    public function getAll()
    {
        $shiftAll = $this->shiftRepository->getAll(); 
        return $shiftAll;
    }
    
    //INSERT
    public function insert($input)
    {
        $this->shiftRepository->insert($input); 
    }
    
    //UPDATE
    public function update($input)
    {
        $this->shiftRepository->update($input); 
    }

    //DESTROY
    public function destroy($input)
    {
        return $this->shiftRepository->destroy($input); 
    }
}