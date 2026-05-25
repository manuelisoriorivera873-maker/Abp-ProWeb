<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductoController; // <--- AGREGADO
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;

// --- RUTAS DE AUTENTICACIÓN ---
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.store');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [LoginController::class, 'showRegister'])->name('register');
Route::post('/register', [LoginController::class, 'storeRegister'])->name('register.store');

// --- RUTAS PROTEGIDAS ---
Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('layouts.template');
    })->name('inicio');

    // Tus recursos (Asegúrate de que los nombres de los controladores coincidan con tus archivos)
    Route::resource('proveedores', 'App\Http\Controllers\ProveedorController');
    Route::resource('productos', 'App\Http\Controllers\ProductoController');
    Route::resource('inicio', 'App\Http\Controllers\InicioController');
    
    // Ruta de ventas corregida
    Route::resource('ventas', 'App\Http\Controllers\VentaController');
    
    Route::resource('detalle_venta', 'App\Http\Controllers\DetalleVentaController');
    Route::resource('pagos_proveedores', 'App\Http\Controllers\PagoProveedorController');
    Route::resource('inventarios_productos', 'App\Http\Controllers\InventarioProductoController');
    Route::resource('recargas_telefonicas', 'App\Http\Controllers\RecargaTelefonicaController');
    Route::resource('saldo_disponible', 'App\Http\Controllers\SaldoDisponibleController');
    Route::resource('cortes_caja', 'App\Http\Controllers\CorteCajaController');
    
    // Ruta personalizada para stock (Corregida la llamada al controlador)
    Route::post('/productos/{id}/sumar', [ProductoController::class, 'sumarStock'])->name('productos.sumar');
    Route::delete('/cortes_caja/{id}', [CorteCajaController::class, 'destroy'])->name('cortes_caja.destroy');
});