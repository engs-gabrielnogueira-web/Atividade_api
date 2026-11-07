<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController; 

Route::get('/pokemon/{nome}', [PokemonController::class, 'buscar']);
