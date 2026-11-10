<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Repositories\ProdutoRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProdutoRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private ProdutoRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new ProdutoRepository();
    }

    public function test_deve_filtrar_produtos_por_nome(): void
    {
        Product::create([
            'nome' => 'Teclado Gamer',
            'preco' => 150,
            'descricao' => 'Teclado mecânico'
        ]);

        Product::create([
            'nome' => 'Mouse',
            'preco' => 80,
            'descricao' => 'Mouse sem fio'
        ]);

        $resultado = $this->repository->search([
            'nome' => 'Teclado'
        ]);

        $this->assertCount(1, $resultado);
        $this->assertEquals('Teclado Gamer', $resultado->first()->nome);
    }

    public function test_deve_filtrar_produtos_por_preco(): void
    {
        Product::create([
            'nome' => 'Teclado',
            'preco' => 150,
            'descricao' => 'Teclado mecânico'
        ]);

        Product::create([
            'nome' => 'Mouse',
            'preco' => 80,
            'descricao' => 'Mouse sem fio'
        ]);

        $resultado = $this->repository->search([
            'preco' => 150
        ]);

        $this->assertCount(1, $resultado);
        $this->assertEquals('Teclado', $resultado->first()->nome);
    }

    public function test_deve_atualizar_produto(): void
    {
        $produto = Product::create([
            'nome' => 'Mouse',
            'preco' => 80,
            'descricao' => 'Mouse simples'
        ]);

        $resultado = $this->repository->update($produto->id, [
            'nome' => 'Mouse Gamer',
            'preco' => 120
        ]);

        $this->assertEquals('Mouse Gamer', $resultado->nome);
        $this->assertEquals('120.00', $resultado->preco);
    }

    public function test_deve_excluir_produto(): void
    {
        $produto = Product::create([
            'nome' => 'Teclado',
            'preco' => 150,
            'descricao' => 'Teclado mecânico'
        ]);

        $resultado = $this->repository->delete($produto->id);

        $this->assertTrue($resultado);
        $this->assertDatabaseMissing('products', [
            'id' => $produto->id
        ]);
    }
}