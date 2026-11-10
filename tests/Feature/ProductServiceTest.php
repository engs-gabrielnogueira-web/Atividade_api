<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase;

    private ProductService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new ProductService();
    }

    public function test_nao_deve_criar_produto_com_preco_invalido(): void
    {
        $dados = [
            'nome' => 'Teclado',
            'preco' => -10,
            'descricao' => 'Teclado mecânico'
        ];

        try {
            validator($dados, [
                'nome' => 'required|string',
                'preco' => 'required|numeric|gt:0',
                'descricao' => 'nullable|string'
            ])->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->assertDatabaseMissing('products', [
                'nome' => 'Teclado'
            ]);

            return;
        }

        $this->fail('O produto não deveria ser aceito com preço inválido.');
    }

    public function test_deve_atualizar_produto(): void
    {
        $produto = Product::create([
            'nome' => 'Mouse',
            'preco' => 50,
            'descricao' => 'Mouse simples'
        ]);

        $dados = [
            'nome' => 'Mouse Gamer',
            'preco' => 150,
            'descricao' => 'Mouse gamer RGB'
        ];

        $resultado = $this->service->update($produto->id, $dados);

        $this->assertEquals('Mouse Gamer', $resultado->nome);
        $this->assertEquals(150, $resultado->preco);
    }

    public function test_nao_deve_atualizar_produto_inexistente(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->service->update(99999, [
            'nome' => 'Produto inexistente',
            'preco' => 100
        ]);
    }
}