<?php

namespace App\Repositories\Category;

interface CategoryRepositoryInterface
{
    public function getAll();
    public function insert($input);
    public function show($input);
    public function update($request);
    public function destroy($input);
}