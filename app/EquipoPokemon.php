<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipoPokemon extends Model
{
    public $timestamps = false;

    public $table = "equipos_pokemones";

    protected $fillable = ['id_equipos', 'id_pokemones', 'orden'];


    public static function crearEquipoPokemon($equipoId, $pokemonId, $orden)
    {

        $equipoPokemon = new EquipoPokemon();
        $equipoPokemon->id_equipos = $equipoId;
        $equipoPokemon->id_pokemones = $pokemonId;
        $equipoPokemon->orden = $orden;
        $equipoPokemon->save();

        return $equipoPokemon;
    }
}
