<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PokemonResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'nome' => $this['nome'],
            'id' => $this['id'],
            'altura' => $this['altura'],
            'peso' => $this['peso'],
            'tipos' => $this['tipos'],
        ];
    }
}