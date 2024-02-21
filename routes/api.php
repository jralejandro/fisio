<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('empleado/{id}/niveles', 'App\Http\Controllers\EmpleadoController@byEmpleado');

Route::get('horas/{turno}/{fisio}/{fecha}/datos', 'App\Http\Controllers\EmpleadoController@byHoras');
//PARA EL CALENDARIO
Route::get('empleado/{id}/todos', 'App\Http\Controllers\EmpleadoController@todosEmpleado');
Route::get('empleado/{id}/sesiones', 'App\Http\Controllers\EmpleadoController@sesionesEmpleado');
//para verificar si hay en un dia una cita
Route::get('horas/{fisio}/{fecha}/{hora}/hsesiones', 'App\Http\Controllers\EmpleadoController@counthorassec');
Route::get('horas/{fisio}/{fecha}/{hora}/{dias}/hordenes', 'App\Http\Controllers\EmpleadoController@counthorasord');
