<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sensor;
use App\Models\TipoSensor;
use App\Models\UnidadMedida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SensorApiController extends Controller
{
    /**
     * Obtener todos los sensores con sus relaciones
     */
    public function index()
    {
        $sensores = Sensor::with(['unidadMedida', 'tipoSensor'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $sensores
        ]);
    }

    /**
     * Obtener un sensor específico por ID
     */
    public function show($id)
    {
        $sensor = Sensor::with(['unidadMedida', 'tipoSensor'])
            ->find($id);

        if (!$sensor) {
            return response()->json([
                'success' => false,
                'message' => 'Sensor no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $sensor
        ]);
    }

    /**
     * Obtener todos los tipos de sensores
     */
    public function tiposSensores()
    {
        $tipos = TipoSensor::all();

        return response()->json([
            'success' => true,
            'data' => $tipos
        ]);
    }

    /**
     * Obtener todas las unidades de medida
     */
    public function unidadesMedida()
    {
        $unidades = UnidadMedida::all();

        return response()->json([
            'success' => true,
            'data' => $unidades
        ]);
    }

    /**
     * Obtener estadísticas de los sensores
     */
    public function estadisticas()
    {
        $estadisticas = [
            'total_sensores' => Sensor::count(),
            'sensores_por_tipo' => Sensor::join('tipo_sensor', 'sensor.tipoSensor_id', '=', 'tipo_sensor.id')
                ->select('tipo_sensor.nombreSensor', DB::raw('COUNT(*) as total'))
                ->groupBy('tipo_sensor.id', 'tipo_sensor.nombreSensor')
                ->get(),
            'sensores_por_unidad' => Sensor::join('unidad_medida', 'sensor.unidadMedida_id', '=', 'unidad_medida.id')
                ->select('unidad_medida.unidadMedida', DB::raw('COUNT(*) as total'))
                ->groupBy('unidad_medida.id', 'unidad_medida.unidadMedida')
                ->get(),
            'ultimas_lecturas' => Sensor::with(['unidadMedida', 'tipoSensor'])
                ->orderBy('fecha', 'desc')
                ->limit(10)
                ->get()
        ];

        return response()->json([
            'success' => true,
            'data' => $estadisticas
        ]);
    }
} 