<?php

namespace App\Services\Discount;

use App\Repositories\Discount\DiscountRepositoryInterface;
use App\Services\Discount\DiscountServiceInterface;

class DiscountService implements DiscountServiceInterface
{
    protected $discountRepository;

    public function __construct(DiscountRepositoryInterface $discountRepository)
    {
        $this->discountRepository = $discountRepository;
    }

    //GET-ALL
    public function getAll()
    {
        $discountAll = $this->discountRepository->getAll(); 
        return $discountAll;
    }
    
    //INSERT
    public function insert($input)
    {
        $this->discountRepository->insert($input); 
    }
    
    //UPDATE
    public function update($input)
    {
        $this->discountRepository->update($input); 
    }

    //DESTROY
    public function destroy($input)
    {
        return $this->discountRepository->destroy($input); 
    }
}