<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\PokemonResource;
class PokemonController extends Controller
{
    public function buscar($nome)
    {
        $url = "https://pokeapi.co/api/v2/pokemon/" . strtolower($nome);

        try {
            $resposta = Http::get($url);

            if ($resposta->failed()) {
                return response()->json([
                    'erro' => 'Pokémon não encontrado ou API indisponível.'
                ], $resposta->status() ?: 404);
            }

            $dados = $resposta->json();

            $tipos = array_map(function ($t) {
                return $t['type']['name'];
            }, $dados['types'] ?? []);

            $pokemonFormatado = [
                'nome' => strtoupper($dados['name']),
                'id' => $dados['id'],
                'altura' => ($dados['height'] / 10) . ' m',
                'peso' => ($dados['weight'] / 10) . ' kg',
                'tipos' => implode(', ', $tipos)
            ];

    return new PokemonResource($pokemonFormatado);
    
        } catch (\Exception $e) {
            return response()->json([
                'erro' => 'Erro interno no servidor.',
                'mensagem' => $e->getMessage()
            ], 500);
        }
    }
}
