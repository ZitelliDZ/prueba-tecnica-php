<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entrenador;
use Faker\Generator as Faker;

$factory->define(Entrenador::class, function (Faker $faker) {
    return [
        'nombre' => $faker->name,
    ];
});
