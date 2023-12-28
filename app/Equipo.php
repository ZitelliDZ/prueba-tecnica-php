<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    public $timestamps = false;

    public $table = "equipos";

    protected $fillable = ['id_entrenadores', 'nombre'];

    public function entrenador()
    {
        return $this->belongsTo(Entrenador::class, 'id_entrenadores');
    }

    public function pokemones()
    {
        return $this->belongsToMany(Pokemon::class, 'equipos_pokemones', 'id_equipos', 'id_pokemones')
            ->withPivot('orden');
    }

    public static function crearEquipo($nombre, $idEntrenador)
    {
        $equipo = new Equipo();
        $equipo->nombre = $nombre;
        $equipo->id_entrenadores = $idEntrenador;
        $equipo->save();

        return $equipo->id;
    }
}
