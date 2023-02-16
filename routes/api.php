<?php

use App\Http\Controllers\PeliculaController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\SalaPeliculaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VentaController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::controller(UsuarioController::class)->group(function () {


    Route::post('register', 'register');
    Route::post('login', 'login');
}); */
Route::group(
    ['middleware' => ["auth:sanctum"]],
    function () {

            Route::get('userProfile',[UsuarioController::class,'userProfile']);
            Route::post('logout',[UsuarioController::class,'logout']);
            Route::post('ventas',[VentaController::class,'store']);
            Route::get('ventas/{id}',[VentaController::class,'show']);
            Route::get('ventas',[VentaController::class,'index']);
            Route::get('ventaslis',[VentaController::class,'listado']);
            Route::get('VentaD',[VentaController::class,'ventaDiaria']);
            Route::get('VentaDU',[VentaController::class,'ventaDiariaUsuario']);
            //ruta salaPelicula
            Route::post('salapelicula',[SalaPeliculaController::class,'store']);
            Route::get('salapelicula',[SalaPeliculaController::class,'index']);
            Route::get('salapelicula/{id}',[SalaPeliculaController::class,'show']);
            //ruta de Pelicula
            Route::get('peliculas',[PeliculaController::class,'index']);
            Route::post('peliculas',[PeliculaController::class,'store']);
            Route::get('peliculas/{id}',[PeliculaController::class,'show']);
            Route::post('peliculas/{id}',[PeliculaController::class,'update']);
            Route::delete('peliculas/{id}',[PeliculaController::class,'destroy']);
            //ruta de salas
            Route::get('salas',[SalaController::class,'index']);
            Route::post('salas',[SalaController::class,'store']);
            Route::get('salas/{id}',[SalaController::class,'show']);
            Route::post('salas/{id}',[SalaController::class,'update']);
            Route::delete('salas/{id}',[SalaController::class,'destroy']);
    }
);



Route::post('register', [UsuarioController::class, 'register']);
Route::post('login', [UsuarioController::class, 'login']);




