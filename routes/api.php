<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReporteApiController;
use App\Http\Controllers\Api\SensorApiController;
use App\Http\Controllers\AlertaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Rutas públicas
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Sensores
    Route::get('/sensores', [SensorApiController::class, 'index']);
    Route::get('/sensores/{id}', [SensorApiController::class, 'show']);
    Route::get('/sensores/tipos', [SensorApiController::class, 'tiposSensores']);
    Route::get('/sensores/unidades', [SensorApiController::class, 'unidadesMedida']);
    Route::get('/sensores/estadisticas', [SensorApiController::class, 'estadisticas']);

    // Reportes
    Route::get('/reportes', [ReporteApiController::class, 'index']);
    Route::get('/reportes/{id}', [ReporteApiController::class, 'show']);
    Route::get('/reportes/sensor/{sensorId}', [ReporteApiController::class, 'bySensor']);
    Route::get('/reportes/sensor/{sensorId}/estadisticas', [ReporteApiController::class, 'estadisticasSensor']);

    // Otras rutas protegidas
    Route::post('/enviar-alerta', [AlertaController::class, 'enviarAlerta']);
});