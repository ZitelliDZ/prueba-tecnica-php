<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    public $timestamps = false;
    public $table = "pokemones";
    protected $fillable = ['id', 'nombre', 'tipo'];


    public function equipos()
    {
        return $this->belongsToMany(Equipo::class, 'equipos_pokemones', 'id_pokemones', 'id_equipos')->withPivot('orden');
    }

    public static function actualizarOrCrearPokemon($code)
    {
        $detalles = self::obtenerDetallesPokemon($code);

        $newPokemon = self::updateOrCreate(
            ['id' => $code],
            [
                'nombre' => $detalles->name,
                'tipo' => $detalles->types[0]->type->name,
            ]
        );
        $newPokemon->id = $code;
        return $newPokemon;
    }

    private static function obtenerDetallesPokemon($code)
    {
        $cliente = new PokeApi();
        $responseJson = $cliente->obtenerDetallesPokemon($code);
        return $responseJson;
    }
}
