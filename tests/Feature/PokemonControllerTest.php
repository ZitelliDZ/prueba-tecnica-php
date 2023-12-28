<?php

namespace Tests\Feature;

use Tests\TestCase;

class PokemonControllerTest extends TestCase
{
    /** @test */
    public function devuelve_lista_de_pokemones()
    {
        $response = $this->get('/api/pokemones/listar');
        $response->assertStatus(200);
    }

    /** @test */
    public function devuelve_un_pokemon_individual()
    {
        $id = 2;
        $response = $this->get('/api/pokemones/' . $id);
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $id,
                    'nombre' => 'ivysaur'
                ]
            ]);
    }

    /** @test */
    public function devuelve_error_para_un_id_de_pokemon_invalido()
    {
        $invalidId = 9999;
        $response = $this->get('/api/pokemones/' . $invalidId);
        $response->assertStatus(500)
            ->assertJson([
                'message' => 'No se encontró el Pokémon ' . $invalidId . '.'
            ]);
    }
}