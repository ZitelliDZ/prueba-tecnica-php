<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Equipo;
use Faker\Generator as Faker;

$factory->define(Equipo::class, function (Faker $faker) {
    return [
        'id_entrenadores' => function () {
            return App\Entrenador::inRandomOrder()->first()->id;
        },
        'nombre' => $faker->words(3, true),
    ];
});
