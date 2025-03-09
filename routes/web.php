<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PruebaController;
use App\Http\Controllers\RegisterController;

use App\Http\Controllers\SensorController;
use App\Http\Controllers\TipoSensorController;
use App\Http\Controllers\UnidadMedidaController;

// Ruta de bienvenida
Route::get('/', function () {
    return view('welcome');
});

Route::get('/prueba', [PruebaController::class, 'saludar']);

// Rutas de autenticación (login)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas de registro
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Ruta protegida (solo accesible para usuarios autenticados)
Route::get('/desktop', function () {
    return view('desktop');
})->middleware('auth');


// Rutas de recursos
Route::resource('sensors', SensorController::class);
Route::resource('tipo-sensors', TipoSensorController::class);
Route::resource('unidad-medidas', UnidadMedidaController::class);
