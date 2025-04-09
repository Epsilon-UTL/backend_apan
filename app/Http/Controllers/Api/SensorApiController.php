<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sensor;
use App\Models\TipoSensor;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\SensorDataUpdated;
use Carbon\Carbon;
use Carbon\CarbonInterval;

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

        if ($rango == 'def') {
            //$rango = 'ultima_semana';
        }

        switch ($rango) {
            case 'def':
                $fechaInicio = now()->subSeconds(30);
                $intervaloMuestreo = null; // No aplicar muestreo para rangos cortos
                break;
            case 'actual':
                $fechaInicio = now()->subMinutes(30);
                $intervaloMuestreo = '5 minutes'; // Muestra cada 5 minutos
                break;
            case 'ultima_hora':
                $fechaInicio = now()->subHour();
                $intervaloMuestreo = '10 minutes'; // Muestra cada 10 minutos
                break;
            case 'ultimo_dia':
                $fechaInicio = now()->subDay();
                $intervaloMuestreo = '1 hour'; // Muestra cada hora
                break;
            case 'ultima_semana':
                $fechaInicio = now()->subWeek();
                $intervaloMuestreo = '6 hours'; // Muestra cada 6 horas
                break;
            case 'custom':
                $fechaInicio = Carbon::parse($request->fecha_inicio);
                $fechaFin = Carbon::parse($request->fecha_fin);

                // Determinar el intervalo de muestreo basado en la duración del rango
                $diasDiferencia = $fechaFin->diffInDays($fechaInicio);
                if ($diasDiferencia <= 1) {
                    $intervaloMuestreo = '10 minutes';
                } elseif ($diasDiferencia <= 7) {
                    $intervaloMuestreo = '1 hour';
                } else {
                    $intervaloMuestreo = '6 hours';
                }
                break;
            default:
                return response()->json(['error' => 'Rango de tiempo inválido'], 400);
        }

        $query = Sensor::where('usuario_id', $usuario->id)
            ->with('tipoSensor');

        if ($rango === 'custom') {
            $query->whereBetween('created_at', [$fechaInicio, $fechaFin]);
        } else {
            $query->where('created_at', '>=', $fechaInicio);
        }

        if (
            in_array($rango, ['ultimo_dia', 'ultima_semana', 'custom']) ||
            ($rango === 'custom' && $diasDiferencia > 1)
        ) {
            $query->selectRaw('
                tipoSensor_id,
                ANY_VALUE(id) as id,
                AVG(valor) as valor,
                ANY_VALUE(created_at) as created_at,
                ANY_VALUE(updated_at) as updated_at,
                ANY_VALUE(usuario_id) as usuario_id,
                DATE_FORMAT(created_at, "%Y-%m-%d %H:00:00") as time_interval
                ')
                ->groupBy('tipoSensor_id', 'time_interval');
        }

        $sensores = $query->get();  

        $valoresMasRecientes = $sensores->groupBy('tipoSensor_id')->map(function ($group) {
            return $group->first();
        })->sortByDesc('created_at');

        return response()->json([
            'recientes' => $valoresMasRecientes,
            'sensores' => $sensores,
            'rango' => $rango,
            'fecha_inicio' => $request->fecha_inicio ?? $fechaInicio ?? null,
            'fecha_fin' => $request->fecha_fin ?? null,
        ]);
    }

    protected function filtrarPorIntervalo($sensores, $intervalo)
    {
        $intervaloSegundos = CarbonInterval::createFromDateString($intervalo)->totalSeconds;
        $sensoresFiltrados = collect();
        $ultimoTiempoPorTipo = [];

        foreach ($sensores as $sensor) {
            $tipoId = $sensor->tipoSensor_id;
            $tiempo = $sensor->created_at->timestamp;

            if (
                !isset($ultimoTiempoPorTipo[$tipoId]) ||
                ($tiempo - $ultimoTiempoPorTipo[$tipoId]) >= $intervaloSegundos
            ) {
                $sensoresFiltrados->push($sensor);
                $ultimoTiempoPorTipo[$tipoId] = $tiempo;
            }
        }

        return $sensoresFiltrados;
    }
}
