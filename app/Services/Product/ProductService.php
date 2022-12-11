<?php

namespace App\Services\Product;

use LaravelEasyRepository\Service;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\Product\ProductServiceInterface;
use Illuminate\Support\Facades\Storage;

class ProductService implements ProductServiceInterface
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

     //GET-ALL
    public function getAll()
    {
        $productAll = $this->productRepository->getAll(); 
        return $productAll;
    }

    //SHOW
    public function show($input)
    {
        $productById = $this->productRepository->show($input); 
        return $productById;
    }
    
    //INSERT
    public function insert($input)
    {
        if(isset($input['photo'])){
            Storage::disk('public')
                    ->put($input['photo']
                    ->getClientOriginalName(), file_get_contents($input['photo']));
        }
        $this->productRepository->insert($input); 
    }
    
    //UPDATE
    public function update($input)
    {
        $this->productRepository->update($input);
    }

    //DESTROY
    public function destroy($input)
    {
        $this->productRepository->destroy($input); 
    }
}