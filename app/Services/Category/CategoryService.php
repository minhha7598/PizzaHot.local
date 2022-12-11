<?php

namespace App\Services\Category;

use App\Repositories\Category\CategoryRepositoryInterface;
use App\Services\Category\CategoryServiceInterface;

class CategoryService implements CategoryServiceInterface
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    //GET-ALL
    public function getAll()
    {
        $categoryAll = $this->categoryRepository->getAll(); 
        return $categoryAll;
    }

    //SHOW
    public function show($input)
    {
        $categoryById = $this->categoryRepository->show($input); 
        return $categoryById;
    }
    
    //INSERT
    public function insert($input)
    {
        if(isset($input['photo'])){
            Storage::disk('public')
                    ->put($input['photo']->getClientOriginalName(), file_get_contents($input['photo']));
        }
        $this->categoryRepository->insert($input); 
    }
    
    //UPDATE
    public function update($input)
    {
        $this->categoryRepository->update($input); 
    }

    //DESTROY
    public function destroy($input)
    {
        return $this->categoryRepository->destroy($input); 
    }
}