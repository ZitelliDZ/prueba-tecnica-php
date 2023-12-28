<?php

namespace App\Api\V1\Controllers;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use App\Equipo;
use App\EquipoPokemon;
use App\Pokemon;

class EquipoController extends Controller
{
    public function listar(Request $request)
    {
        try {
            $id_entrenador = Route::current()->parameters()['id_entrenador'] ?? null;

            $validator = Validator::make(['id_entrenador' => $id_entrenador], [
                'id_entrenador' => 'required|exists:entrenadores,id'
            ]);
            if ($validator->fails()) {
                return (new ResponseController())->validationError($validator->errors(), 'Error de validación', 422);
            }

            $equipos = Equipo::with(['pokemones', 'entrenador'])->where('id_entrenadores', $request->id_entrenador)->paginate(15);
            return (new ResponseController())->success($equipos, 'Listado de equipos', 200);

        } catch (Exception $e) {
            return (new ResponseController())->error($e->getMessage(), 500);
        }
    }



    public function detalle($id)
    {
        try {
            $id = Route::current()->parameters()['id'] ?? null;
            $validator = Validator::make(['id' => $id], [
                'id' => 'required|exists:equipos,id'
            ],
                [
                    'id.required' => 'El id del equipo es requerido',
                    'id.exists' => 'El id del equipo no existe'
                ]);
            if ($validator->fails()) {
                return (new ResponseController())->validationError($validator->errors(), 'Error de validación', 422);
            }
            $equipo = Equipo::with(['pokemones', 'entrenador'])->find($id);

            if (!$equipo) {
                return (new ResponseController())->error('No se encontro el equipo.', 404);
            }

            return (new ResponseController())->success($equipo, 'Detalle del equipo', 200);
        } catch (Exception $e) {
            return (new ResponseController())->error($e->getMessage(), 500);
        }
    }

    private function validarDatosCrear($data)
    {
        $validator = Validator::make($data, [
            'nombre' => 'required',
            'id_entrenadores' => 'required|exists:entrenadores,id',
            'pokemones' => 'required|array|max:3',
            'pokemones.*.id' => 'required'
        ]);

        return $validator;

    }

    public function crear()
    {
        try {
            //Validaciones
            $validator = $this->validarDatosCrear(request()->all());
            if ($validator->fails()) {
                return (new ResponseController())->validationError($validator->errors(), 'Error de validación', 422);
            }
            //Inicio de Transacción
            DB::beginTransaction();

            $equipoId = Equipo::crearEquipo(request()->nombre, request()->id_entrenadores);

            $pokemones = request()->pokemones;
            $equipoPokemones = [];

            foreach ($pokemones as $key => $pokemonData) {

                $pokemon = Pokemon::find($pokemonData['id']);

                if (!$pokemon) {
                    $pokemon = Pokemon::actualizarOrCrearPokemon($pokemonData['id']);
                }

                $equipoPokemon = EquipoPokemon::crearEquipoPokemon($equipoId, $pokemonData['id'], $key + 1);

                $equipoPokemon->id = $pokemonData['id'];
                $equipoPokemones[$pokemonData['id']] = $equipoPokemon;
            }


            $equipo = Equipo::find($equipoId);
            DB::commit();

            return (new ResponseController())->success([
                'equipo' => $equipo,
                'pokemones' => $equipoPokemones
            ], 'Equipo creado con éxito.', 201);


        } catch (Exception $e) {
            DB::rollBack();
            return (new ResponseController())->error($e->getMessage(), 500);
        }
    }

}
