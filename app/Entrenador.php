<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entrenador extends Model
{
    public $timestamps = false;

    public $table = "entrenadores";

    protected $fillable = ['nombre'];

    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'id_entrenadores');
    }

}
