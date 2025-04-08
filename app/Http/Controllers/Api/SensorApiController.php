<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sensor;
use App\Models\TipoSensor;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\SensorDataUpdated;

class SensorApiController extends Controller
{
    public function guardarDatos(Request $request)
    {
        if ($request->has("usuario_uuid")) {
            $request->merge(['usuario_uuid' => $request->usuario_uuid]);
        } else {
            return response()->json(['error' => 'El campo usuario_uuid es requerido'], 422);
        }

        if ($request->has("sensores")) {
            $request->merge(['sensores' => $request->sensores]);
        } else {
            return response()->json(['error' => 'El campo sensores es requerido'], 422);
        }

        $user = User::where('id', $request->usuario_uuid)->first();

        foreach ($request->sensores as $sensorData) {
            $sensor = TipoSensor::where('id', $sensorData['tipo'])->first();

            if ($sensor) {
                $registro = new Sensor();
                $registro->tipoSensor_id = $sensor->id;
                $registro->usuario_id = $user->id;
                $registro->valor = $sensorData['valor'];
                $registro->save();
            }
        }

        $fechaInicio = now()->subSeconds(30);
        $sensores = Sensor::where('usuario_id', $user->id)
                ->where('created_at', '>=', $fechaInicio)
                ->with('tipoSensor')
                ->latest()
                ->get();
                
        $valoresMasRecientes = $sensores->groupBy('tipoSensor_id')->map(function ($group) {
            return $group->first();
        })->sortByDesc('created_at');
        
        event(new SensorDataUpdated([
            'recientes' => $valoresMasRecientes,
            'sensores' => $sensores,
            'fecha_inicio' => $request->fecha_inicio ?? null,
            'fecha_fin' => $request->fecha_fin ?? null,
        ]));

        return response()->json(['message' => 'Datos guardados correctamente'], 201);
    }

    public function obtenerDatosPorRango(Request $request, $rango)
    {
        $usuario = $this->user($request->header('Jwt'));
        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 200);
        }

        if ($rango == 'custom' && (!$request->fecha_inicio || !$request->fecha_fin)) {
            return response()->json(['error' => 'Las fechas son requeridas'], 200);
        }
    
        switch ($rango) {
            case 'def':
                //$fechaInicio = now()->subHour();
                $fechaInicio = now()->subSeconds(30);
                break;
            case 'actual':
                $fechaInicio = now()->subMinutes(30);
                break;
            case 'ultima_hora':
                //$fechaInicio = now()->subHour();
                $fechaInicio = now()->subSeconds(30);
                break;
            case 'ultimo_dia':
                $fechaInicio = now()->subDay();
                break;
            case 'ultima_semana':
                $fechaInicio = now()->subWeek();
                break;
            case 'custom':
                // Para el rango custom, se usan las fechas proporcionadas
                $fechaInicio = $request->fecha_inicio;
                $fechaFin = $request->fecha_fin;
                break;
            default:
                return response()->json(['error' => 'Rango de tiempo inválido'], 400);
        }
    
        if ($rango === 'custom') {
            $sensores = Sensor::where('usuario_id', $usuario->id)
                ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->with('tipoSensor')
                ->latest()
                ->get();
        } else {
            $sensores = Sensor::where('usuario_id', $usuario->id)
                ->where('created_at', '>=', $fechaInicio)
                ->with('tipoSensor')
                ->latest()
                ->get();
        }
    
        $valoresMasRecientes = $sensores->groupBy('tipoSensor_id')->map(function ($group) {
            return $group->first();
        })->sortByDesc('created_at');
        

        return response()->json([
            'recientes' => $valoresMasRecientes,
            'sensores' => $sensores,
            'rango' => $rango,
            'fecha_inicio' => $request->fecha_inicio ?? null,
            'fecha_fin' => $request->fecha_fin ?? null,
        ]);
    }    
}
