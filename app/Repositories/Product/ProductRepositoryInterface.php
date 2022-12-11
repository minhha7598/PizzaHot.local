<?php

namespace App\Repositories\Product;

interface ProductRepositoryInterface
{
    public function getAll();
    public function insert($input);
    public function show($input);
    public function update($request);
    public function destroy($input);
}