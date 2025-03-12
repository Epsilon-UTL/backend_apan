<?php

use App\Events\NotificationEvent;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PruebaController;
use App\Http\Controllers\RegisterController;

use App\Http\Controllers\SensorController;
use App\Http\Controllers\TipoSensorController;
use App\Http\Controllers\UnidadMedidaController;

use Illuminate\Support\Facades\Broadcast;


// Ruta de bienvenida
Route::get('/', function () {
    //return view('welcome');
    return Auth::check() ? redirect('/desktop') : redirect('/login');
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
Route::middleware('auth')->group(function () {
    
    // Ruta protegida (solo accesible para usuarios autenticados)
    Route::get('/desktop', function () {
        return view('desktop');
    })->name('desktop');

    // Rutas de recursos
    Route::resource('sensors', SensorController::class);
    Route::resource('tipo-sensors', TipoSensorController::class);
    Route::resource('unidad-medidas', UnidadMedidaController::class);
});

Broadcast::channel('user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Route::post('/send-notification', function () {
    $users = \App\Models\User::all();
    foreach ($users as $user) {
        event(new NotificationEvent($user, 'Nueva notificación para todos los usuarios'));
    }

    return 'Notificación enviada a todos los usuarios';
});