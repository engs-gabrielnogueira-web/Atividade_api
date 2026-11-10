<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function update(int $id, array $dados): Product
    {
        $produto = Product::findOrFail($id);

        $produto->update($dados);

        return $produto;
    }
}