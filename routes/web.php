<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\VendedorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ConserjeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('inicio');
})->name('inicio');

Route::resource('login', LoginController::class);

Route::resource('vendedor', VendedorController::class);

Route::get('/clientes/{id}', [ClienteController::class, 'show']);

Route::get('/conserje/filtrar', [ConserjeController::class, 'filtrarPorFecha'])->name('conserje.filtrarPorFecha');
Route::post('/conserje/actualizar-estado/{id}', [ConserjeController::class, 'actualizarEstado'])->name('conserje.actualizarEstado');
Route::resource('conserje', ConserjeController::class);
