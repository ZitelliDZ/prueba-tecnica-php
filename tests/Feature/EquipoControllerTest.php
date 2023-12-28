<?php

namespace Tests\Feature;

use App\Entrenador;
use App\Equipo;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;


class EquipoControllerTest extends TestCase
{
    use WithFaker;
    /** @test */
    public function puede_listar_equipos_de_un_entrenador_existente()
    {
        $equipo = factory(Equipo::class)->create();
        $id_entrenador = $equipo->id_entrenadores;
        $response = $this->get("/api/equipos/listar/$id_entrenador");
        $response->assertStatus(200);
    }

    /** @test */
    public function puede_obtener_detalle_de_un_equipo_existente()
    {

        $equipo = factory(Equipo::class)->create();
        $response = $this->get("/api/equipos/{$equipo->id}");
        $response->assertStatus(200)
            ->assertJson([
                "status" => "success",
                "data" => [
                    "id" => $equipo->id,
                    "nombre" => $equipo->nombre,
                    "pokemones" => []
                ]
            ]);
    }

    /** @test */
    public function obtiene_un_error_para_id_de_equipo_invalido()
    {
        $invalidId = 9999;

        $response = $this->get("/api/equipos/$invalidId");
        $response->assertStatus(422)
            ->assertJson([
                "status" => "error",
                "message" => "Error de validación",
                "errors" => [
                    "id" => ["El id del equipo no existe"]
                ]
            ]);
    }


    /** @test */
    public function it_creates_an_equipo_with_pokemones()
    {

        $data = [
            'nombre' => $this->faker->name,
            'id_entrenadores' => factory(Entrenador::class)->create()->id,
            'pokemones' => [
                ['id' => 25],
                ['id' => 44],
                ['id' => 55]
            ]
        ];

        $response = $this->post('/api/equipos/crear', $data);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Equipo creado con éxito.',
                'data' => [
                    'equipo' => [
                        'nombre' => $data['nombre'],
                    ],
                ]
            ]);
    }
}
