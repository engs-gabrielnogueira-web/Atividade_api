<?php

namespace App\Repositories;

use App\Models\Product;

class ProdutoRepository
{
    public function search(array $filtros = [])
    {
        $query = Product::query();

        if (!empty($filtros['nome'])) {
            $query->where('nome', 'LIKE', '%' . $filtros['nome'] . '%');
        }

        if (!empty($filtros['preco'])) {
            $query->where('preco', $filtros['preco']);
        }

        return $query->get();
    }
    public function update(int $id, array $dados): Product
    {
        $produto = Product::findOrFail($id);

        $produto->update($dados);

        return $produto;
    }

    public function delete(int $id): bool
    {
        $produto = Product::findOrFail($id);

        return $produto->delete();
    }
}