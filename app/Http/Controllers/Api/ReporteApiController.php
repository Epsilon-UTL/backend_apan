<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reporte;
use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteApiController extends Controller
{
    /**
     * Obtener todos los reportes con información de sensores
     */
    public function index()
    {
        $reportes = Reporte::with(['sensor', 'sensor.unidadMedida', 'sensor.tipoSensor', 'estatusReporte', 'usuario'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $reportes
        ]);
    }

    /**
     * Obtener un reporte específico por ID
     */
    public function show($id)
    {
        $reporte = Reporte::with(['sensor', 'sensor.unidadMedida', 'sensor.tipoSensor', 'estatusReporte', 'usuario'])
            ->find($id);

        if (!$reporte) {
            return response()->json([
                'success' => false,
                'message' => 'Reporte no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $reporte
        ]);
    }

    /**
     * Obtener reportes por sensor
     */
    public function bySensor($sensorId)
    {
        $sensor = Sensor::find($sensorId);
        
        if (!$sensor) {
            return response()->json([
                'success' => false,
                'message' => 'Sensor no encontrado'
            ], 404);
        }

        $reportes = Reporte::with(['sensor', 'sensor.unidadMedida', 'sensor.tipoSensor', 'estatusReporte', 'usuario'])
            ->where('sensor_id', $sensorId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'sensor' => $sensor,
            'data' => $reportes
        ]);
    }

    /**
     * Obtener estadísticas de reportes por sensor
     */
    public function estadisticasSensor($sensorId)
    {
        $sensor = Sensor::with(['unidadMedida', 'tipoSensor'])->find($sensorId);
        
        if (!$sensor) {
            return response()->json([
                'success' => false,
                'message' => 'Sensor no encontrado'
            ], 404);
        }

        $estadisticas = Reporte::where('sensor_id', $sensorId)
            ->select(
                DB::raw('COUNT(*) as total_reportes'),
                DB::raw('MIN(fecha) as fecha_primera'),
                DB::raw('MAX(fecha) as fecha_ultima'),
                DB::raw('COUNT(DISTINCT usuario_id) as total_usuarios')
            )
            ->first();

        $estadisticasPorEstatus = Reporte::where('sensor_id', $sensorId)
            ->join('estatus_reportes', 'reportes.estatus_id', '=', 'estatus_reportes.id')
            ->select('estatus_reportes.estatus', DB::raw('COUNT(*) as total'))
            ->groupBy('estatus_reportes.id', 'estatus_reportes.estatus')
            ->get();

        return response()->json([
            'success' => true,
            'sensor' => $sensor,
            'estadisticas' => $estadisticas,
            'estadisticas_por_estatus' => $estadisticasPorEstatus
        ]);
    }
} 