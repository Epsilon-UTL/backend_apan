<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReporteApiController;
use App\Http\Controllers\Api\SensorApiController;
use App\Http\Controllers\AlertaController;
use App\Http\Middleware\ValidateJwt;
use Illuminate\Support\Facades\Route;

// Rutas públicas
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Rutas protegidas
Route::middleware([ValidateJwt::class])->group(function () {
    // Auth
    Route::post('/changePassword', [AuthController::class, 'changePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Sensores
    Route::prefix('/sensores')->group(function () {
        Route::post('/guardarDatos', [SensorApiController::class, 'guardarDatos']);
        Route::post('/obtenerDatos/{rango}', [SensorApiController::class, 'obtenerDatosPorRango']);        
    });

    // Reportes
    Route::prefix('/reportes')->group(function () {
        Route::get('', [ReporteApiController::class, 'index']);
        Route::get('/{id}', [ReporteApiController::class, 'show']);
        Route::get('/sensor/{sensorId}', [ReporteApiController::class, 'bySensor']);
        Route::get('/sensor/{sensorId}/estadisticas', [ReporteApiController::class, 'estadisticasSensor']);
    });

    // Otras rutas protegidas
    Route::post('/enviar-alerta', [AlertaController::class, 'enviarAlerta']);
});
