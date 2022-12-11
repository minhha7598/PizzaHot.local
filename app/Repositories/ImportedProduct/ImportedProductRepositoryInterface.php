<?php

namespace App\Repositories\ImportedProduct;

interface ImportedProductRepositoryInterface
{
    public function getAll();
    public function insert($input);
    public function update($input);
    public function destroy($input);
}