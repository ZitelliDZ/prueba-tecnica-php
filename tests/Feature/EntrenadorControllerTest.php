<?php

namespace Tests\Feature;

use App\Entrenador;
use Tests\TestCase;

class EntrenadorControllerTest extends TestCase
{

    /** @test */
    public function puede_crear_un_entrenador()
    {
        $data = [
            'nombre' => 'Ash Ketchum'
        ];

        $response = $this->post('/api/entrenadores/crear', $data);
        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'nombre' => 'Ash Ketchum'
                ]
            ]);
    }

    /** @test */
    public function puede_obtener_el_detalle_de_un_entrenador_existente()
    {
        $entrenador = factory(Entrenador::class)->create();

        $response = $this->get('/api/entrenadores/' . $entrenador->id);
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $entrenador->id,
                    'nombre' => $entrenador->nombre
                ]
            ]);
    }

    /** @test */
    public function devuelve_un_error_al_obtener_el_detalle_de_un_entrenador_inexistente()
    {
        $idInexistente = 9999;

        $response = $this->get('/api/entrenadores/' . $idInexistente);
        $response->assertStatus(500)
            ->assertJson([
                'message' => 'No se encontro el entrenador.'
            ]);
    }

    /** @test */
    public function devuelve_un_error_de_validacion_al_crear_un_entrenador_sin_nombre()
    {
        $data = [
            // 'nombre' => 'Ash Ketchum'
        ];

        $response = $this->post('/api/entrenadores/crear', $data);
        $response->assertStatus(422)
            ->assertJson([
                'message' => 'Error de validación',
                'errors' => [
                    'nombre' => [
                        'El campo nombre es obligatorio.'
                    ]
                ]
            ]);
    }
}
