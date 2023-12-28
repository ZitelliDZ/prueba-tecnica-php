<?php

namespace App\Api\V1\Controllers;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Entrenador;

class EntrenadorController extends Controller
{


    private function validarDatosCrear(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:30' // Reglas de validación para el nombre
        ]);

        return $validator;

    }
    public function crear(Request $request)
    {
        try {

            $validator = $this->validarDatosCrear($request);

            if ($validator->fails()) {
                return (new ResponseController())->validationError($validator->errors(), 'Error de validación', 422);
            }

            $entrenador = Entrenador::create([
                'nombre' => $request->nombre
            ]);

            return (new ResponseController())->success($entrenador, 'Entrenador creado con éxito.', 201);
        } catch (Exception $e) {
            return (new ResponseController())->error($e->getMessage(), 500);
        }


    }

    public function detalle(Request $request)
    {
        try {
            $entrenador = Entrenador::find($request->id);

            if (!$entrenador) {
                throw new Exception("No se encontro el entrenador.");
            }

            return (new ResponseController())->success($entrenador, 'Detalle del entrenador', 200);

        } catch (Exception $e) {
            return (new ResponseController())->error($e->getMessage(), 500);
        }

    }
}
