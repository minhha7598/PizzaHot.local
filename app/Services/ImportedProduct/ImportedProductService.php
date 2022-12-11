<?php

namespace App\Services\ImportedProduct;

use App\Repositories\ImportedProduct\ImportedProductRepositoryInterface;
use App\Services\ImportedProduct\ImportedProductServiceInterface;

class ImportedProductService implements ImportedProductServiceInterface
{
    protected $importedProductRepository;

    public function __construct(ImportedProductRepositoryInterface $importedProductRepository)
    {
        $this->importedProductRepository = $importedProductRepository;
    }

    //GET-ALL
    public function getAll()
    {
        $shiftAll = $this->importedProductRepository->getAll(); 
        return $shiftAll;
    }
    
    //INSERT
    public function insert($input)
    {
        $this->importedProductRepository->insert($input); 
    }
    
    //UPDATE
    public function update($input)
    {
        $this->importedProductRepository->update($input); 
    }

    //DESTROY
    public function destroy($input)
    {
        return $this->importedProductRepository->destroy($input); 
    }
}