<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\VendedorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ConserjeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/quienes-somos', function () {
    return view('quienesSomos');
})->name('quienesSomos');
Route::post('/login', [LoginController::class, 'login'])->name('login.store');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.login');
Route::post('/clientes/log', [ClienteController::class, 'login'])->name('clientesLogin');
Route::get('/cliente/dashboard/{id}', [ClienteController::class, 'clienteDashboard'])->name('cliente.dashboard');


Route::middleware(['auth', 'rol:conserje,administrador' ])->group(function () {
    Route::get('/conserje/dashboard', function () {
        return view('conserje.vistaConserje');
    })->name('conserje.dashboard');

    Route::get('/conserje/filtrar', [ConserjeController::class, 'filtrarPorFecha'])->name('conserje.filtrarPorFecha');
    Route::post('/conserje/actualizar-estado/{id}', [ConserjeController::class, 'actualizarEstado'])->name('conserje.actualizarEstado');
    Route::get('/conserje/ordenarPuesto', [ConserjeController::class, 'ordenarPorPuesto'])->name('conserje.ordenarPorPuesto');
    Route::get('/conserje/ordenarCliente', [ConserjeController::class, 'ordenarPorCliente'])->name('conserje.ordenarPorCliente');

    Route::get('/admin/clientes', [ConserjeController::class, 'clientes'])->name('conserje.clientes');
    Route::post('/conserje/anyadir_clientes', [ConserjeController::class, 'anyadirClientes'])->name('conserje.anyadirClientes');

    Route::get('/admin/direcciones', [ConserjeController::class, 'direcciones'])->name('conserje.direcciones');
    Route::post('/conserje/anyadir_direcciones', [ConserjeController::class, 'anyadirDirecciones'])->name('conserje.anyadirDirecciones');

    Route::get('/conserje/actualizar-estadoqr/{id}', [ConserjeController::class, 'actuaizarEstadoPedidoQR'])->name('conserje.actualizarEstadoQR');


    Route::resource('conserje', ConserjeController::class);
});

Route::middleware(['auth', 'rol:administrador'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/listado_usuarios', [AdminController::class, 'usuarios'])->name('admin.usuarios');
    Route::get('/admin/baja_usuarios/{id}', [AdminController::class, 'darBajaUsuarios'])->name('baja.usuarios');
    Route::post('/admin/anyadir_usuarios', [AdminController::class, 'anyadirUsuarios'])->name('anyadir.usuarios');



    Route::get('/admin/listado_puestos', [AdminController::class, 'puestos'])->name('admin.puestos');
    Route::get('/admin/baja_puestos/{id}', [AdminController::class, 'darBajaPuestos'])->name('baja.puestos');
    Route::post('/admin/anyadir_puestos', [AdminController::class, 'anyadirPuestos'])->name('anyadir.puestos');

    Route::get('/admin/listado_mercados', [AdminController::class, 'mercados'])->name('admin.mercados');
    Route::get('/admin/baja_mercados/{id}', [AdminController::class, 'darBajaMercados'])->name('baja.mercados');
    Route::post('/admin/anyadir_mercados', [AdminController::class, 'anyadirMercados'])->name('anyadir.mercados');

    Route::resource('admin', AdminController::class);

});

Route::middleware(['auth', 'rol:vendedor,administrador'])->group(function () {
    Route::get('/vendedor/dashboard', [VendedorController::class, 'index'])->name('vendedor.dashboard');

    Route::resource('vendedor', VendedorController::class);
});

// Rutas accesibles para cualquier usuario autenticado
Route::middleware('auth')->group(function () {
    Route::get('/clientes/{id}', [ClienteController::class, 'show']);
});
