
<?php
use Illuminate\Support\Facades\Route;


Route::prefix('pokemones')->group(function () {
    Route::get('listar', 'PokemonController@listar');
    Route::get('{id}', 'PokemonController@detalle')->where('id', '[0-9]+');
});
Route::prefix('entrenadores')->group(function () {
    Route::post('crear', 'EntrenadorController@crear');
    Route::get('{id}', 'EntrenadorController@detalle')->where('id', '[0-9]+');
});
Route::prefix('equipos')->group(function () {
    Route::get('listar/{id_entrenador}', 'EquipoController@listar')->where('id_entrenador', '[0-9]+');
    Route::post('crear', 'EquipoController@crear');
    Route::get('{id}', 'EquipoController@detalle')->where('id', '[0-9]+');
});
