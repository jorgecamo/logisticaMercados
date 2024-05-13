<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\VendedorController;
use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('inicio');
})->name('inicio');

Route::resource('login', LoginController::class);

Route::resource('vendedor', VendedorController::class);

Route::get('/clientes/{id}', [ClienteController::class, 'show']);
