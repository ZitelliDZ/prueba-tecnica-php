<?php

namespace App\Api\V1\Controllers;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Pokemon;

class PokemonController extends Controller
{
    public function listar()
    {
        try {
            $pokemones = Pokemon::paginate(10);

            return (new ResponseController())->success($pokemones, 'Listado de pokemones', 200);
        } catch (Exception $e) {

            return (new ResponseController())->error($e->getMessage(), 500);
        }
    }

    public function detalle(Request $request)
    {
        try {
            $pokemon = Pokemon::find($request->id);

            if (!$pokemon) {
                $pokemon = Pokemon::actualizarOrCrearPokemon($request->id);

                return (new ResponseController())->success($pokemon, 'Detalle del pokemon', 200);
            }

            return (new ResponseController())->success($pokemon, 'Detalle del pokemon', 200);
        } catch (Exception $e) {
            return (new ResponseController())->error($e->getMessage(), 500);
        }
    }






}
