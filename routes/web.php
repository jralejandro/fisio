<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ReporteController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('layouts.app');
// });
Route::get('/', function () {
    return view('auth.login');
});

//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//preuba de pdf
Route::get('/pdfprueba', [App\Http\Controllers\HomeController::class, 'pdfPrueba']);


//Para Usuarios
// Route::get('usuarios','UserController@index')->name('usuarios.index');
Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
Route::get('/usuarios/create', [UserController::class, 'create'])->name('usuarios.create');
Route::post('/usuarios/store', [UserController::class, 'store'])->name('usuarios.store');
// Route::get('/users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
// Route::put('/users/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
Route::get('/usuarios/{usuario}/edit', [UserController::class, 'edit'])->name('usuarios.edit');
Route::post('/usuarios/{usuario}', [UserController::class, 'update'])->name('usuarios.update');
Route::get('/usuarios/{usuario}/show', [UserController::class, 'show'])->name('usuarios.show');
Route::get('/usuarios/{usuario}/inactivo', [UserController::class, 'inactivo'])->name('usuarios.inactivo');

//Para Pacientes
Route::get('/pacientes', [PacienteController::class, 'index'])->name('pacientes.index');
Route::get('/pacientes/create', [PacienteController::class, 'create'])->name('pacientes.create');
Route::post('/pacientes/store', [PacienteController::class, 'store'])->name('pacientes.store');
// Route::get('/users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
// Route::put('/users/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
Route::get('/pacientes/{paciente}/edit', [PacienteController::class, 'edit'])->name('pacientes.edit');
Route::post('/pacientes/{paciente}', [PacienteController::class, 'update'])->name('pacientes.update');
Route::get('/pacientes/{paciente}/show', [PacienteController::class, 'show'])->name('pacientes.show');
// para registro de control pacientes
Route::get('/ordenes/{paciente}/orden', [PacienteController::class, 'orden'])->name('ordenes.orden');
Route::get('/ordenes/{paciente}/ocreate', [PacienteController::class, 'ocreate'])->name('ordenes.ocreate');
Route::post('/ordenes/ostore', [PacienteController::class, 'ostore'])->name('ordenes.ostore');
Route::get('/ordenes/{orden}/oedit', [PacienteController::class, 'oedit'])->name('ordenes.oedit');
Route::post('/ordenes/{orden}', [PacienteController::class, 'oupdate'])->name('ordenes.oupdate');

//horarios
Route::post('/horas/horastore', [PacienteController::class, 'horastore'])->name('horas.horastore');

//Para las bandejas de los fisioterapeutas
Route::get('/bandejas', [PacienteController::class, 'bindex'])->name('bandejas.index');
//Para Historiales
Route::get('/historiales/{paciente}/historial', [PacienteController::class, 'historial'])->name('historiales.historial');
Route::get('/historiales/{paciente}/hcreate', [PacienteController::class, 'hcreate'])->name('historiales.hcreate');
Route::post('/historiales/hstore', [PacienteController::class, 'hstore'])->name('historiales.hstore');
//Para Citas
Route::get('/citas/{paciente}/{orden}/programar', [PacienteController::class, 'cindex'])->name('citas.index');
Route::post('/citas/cstore', [PacienteController::class, 'cstore'])->name('citas.cstore');
Route::get('/citasF', [PacienteController::class, 'cfindex'])->name('citas.indexf');

//Para las sesiones
Route::get('/sesiones/{paciente}/sesion', [PacienteController::class, 'sesion'])->name('sesiones.sesion');
Route::get('/sesiones/{sesion}/screate', [PacienteController::class, 'screate'])->name('sesiones.screate');
Route::get('/sesiones/{sesion}/svaciar', [PacienteController::class, 'svaciar'])->name('sesiones.svaciar');
Route::post('/sesiones/{sesion}', [PacienteController::class, 'sestore'])->name('sesiones.sestore');
Route::get('/sesiones/{sesion}/noasistio', [PacienteController::class, 'noasistio'])->name('sesiones.noasistio');
Route::get('/sesiones/{sesion}/show', [PacienteController::class, 'sshow'])->name('sesiones.sshow');

//Para Reportes
Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
Route::get('/reportes/pdfPersonal', [ReporteController::class, 'pdfPersonal'])->name('reportes.personal');
Route::get('/reportes/{historial}/pdfPacienteHistorico', [ReporteController::class, 'pdfPacienteHistorico'])->name('reportes.pacientehistorico');
Route::get('/reportes/{historial}/pdfCitas', [ReporteController::class, 'pdfCitas'])->name('reportes.pdfCitas');

//para historial de todos los paciente
Route::get('/historiales', [PacienteController::class, 'hindex'])->name('historiales.index');

//informes
Route::get('/informes', [PacienteController::class, 'inindex'])->name('informes.inindex'); //realizar
Route::get('/informes/{paciente}/icreate', [PacienteController::class, 'icreate'])->name('informes.icreate');
Route::post('/informes/infostore', [PacienteController::class, 'infostore'])->name('informes.infostore');
Route::get('/informes/{historial}/show', [PacienteController::class, 'inshow'])->name('informes.inshow');

//investigacion
Route::get('/investigacion', [PacienteController::class, 'invesindex'])->name('investigacion.invesindex');