<?php

namespace App\Services\Product;

interface ProductServiceInterface 
{
    public function getAll();
    public function show($input);
    public function insert($input);
    public function update($input);
    public function destroy($input);
}