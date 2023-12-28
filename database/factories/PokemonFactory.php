<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Pokemon;
use Faker\Generator as Faker;


$factory->define(Pokemon::class, function (Faker $faker) {
    return [
        'nombre' => $faker->word,
        'tipo' => $faker->randomElement(['fire', 'water', 'grass', 'electric']),
    ];
});

