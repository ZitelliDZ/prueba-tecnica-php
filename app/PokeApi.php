<?php

namespace App;

use Exception;
use GuzzleHttp\Client;

class PokeApi
{
    private $urlApi = "https://pokeapi.co/api/v2/";

    public function getUrlApi()
    {
        return $this->urlApi;
    }

    public function obtenerDetallesPokemon($code)
    {
        try {
            $client = new Client();
            $response = $client->get($this->urlApi . 'pokemon/' . $code);
            return json_decode($response->getBody());
        } catch (Exception $th) {
            throw new Exception("No se encontró el Pokémon " . $code . ".");
        }
    }
}
