<?php

use App\Http\Controllers\EstatusReporteController;
use App\Http\Controllers\ReporteSimuladorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;

use App\Http\Controllers\SensorController;
use App\Http\Controllers\TipoSensorController;
use App\Http\Controllers\UnidadMedidaController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return Auth::check() ? redirect('/desktop') : redirect('/login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware('auth')->group(function () {

    Route::get('/desktop', [HomeController::class, 'index'])->name('desktop');
    
    Route::resource('sensors', SensorController::class);
    Route::resource('tipo-sensors', TipoSensorController::class);
    Route::resource('unidad-medidas', UnidadMedidaController::class);
    Route::resource('usuarios', UserController::class);
    Route::resource('estatus-reportes', EstatusReporteController::class);

    Route::prefix('simulador/reportes')->group(function () {
        Route::get('/crear', [ReporteSimuladorController::class, 'create'])->name('simulador.reportes.create');
        Route::post('/crear', [ReporteSimuladorController::class, 'store'])->name('simulador.reportes.store');
        
        Route::get('/masivo', [ReporteSimuladorController::class, 'createMassive'])->name('simulador.reportes.create-massive');
        Route::post('/masivo', [ReporteSimuladorController::class, 'storeMassive'])->name('simulador.reportes.storeMassive');
    });
});


Route::get('/pruebaSockets', function(){
    return view('/sockets');
});

use App\Events\SensorDataUpdated;

Route::get('/probar-broadcast', function () {
    event(new SensorDataUpdated(['prueba' => 'ok']));
    return 'Evento enviado';
});