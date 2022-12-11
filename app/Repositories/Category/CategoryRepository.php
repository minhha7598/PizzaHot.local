<?php

namespace App\Repositories\Category;

use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    //GET-ALL
    public function getAll()
    {
        $categoryAll = Category::all();
        return $categoryAll;
    }
    
    //SHOW
    public function show($input)
    {
        $categoryById = Category::Where('id', $input);
        return $categoryById->first();
    }

    //INSERT
    public function insert($input)
    {
        Category::create([
            'category_name' => $input['category_name'],
            'description' => $input['description']
        ]);
    }

    //UPDATE
    public function update($input)
    {
        $categoryById = Category::Where('id', '=', $input['id']);
        $odlValue = Category::Where('id', $input['id'])->first();

        //update
        $categoryById->update([
            'category_name' => $input['category_name']?$input['category_name']:$odlValue['category_name'],
            'description' => $input['description']?$input['description']:$odlValue['description'],
        ]);
    }

    //DESTROY
    public function destroy($input)
    {
        $categoryById = Category::find($input);
        $categoryById->delete();
    }
}