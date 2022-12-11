<?php

namespace App\Services\ImportedProduct;

interface ImportedProductServiceInterface {
    public function getAll();
    public function insert($input);
    public function update($input);
    public function destroy($input);
}