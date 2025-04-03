<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use App\Models\Reporte;
use App\Models\User;
use App\Models\TipoSensor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{

    public function index()
    {
        $totalSensores = Sensor::count();
        $tiposSensores = TipoSensor::withCount('sensors')->get();
        
        $ultimasLecturas = Sensor::with(['unidadMedida', 'tipoSensor'])
                                ->orderBy('fecha', 'desc')
                                ->take(5)
                                ->get();
        
        $totalReportes = Reporte::count();
        $reportesAbiertos = Reporte::where('estatus_id', 1)->count();
        $reportesResueltos = Reporte::where('estatus_id', 2)->count();
        
        $lecturasPorDia = Sensor::selectRaw('DATE(fecha) as date, COUNT(*) as count')
                               ->where('fecha', '>=', Carbon::now()->subDays(7))
                               ->groupBy('date')
                               ->orderBy('date')
                               ->get();
        
        $reportesPorEstado = Reporte::selectRaw('estatus_id, COUNT(*) as count')
                                  ->groupBy('estatus_id')
                                  ->with('EstatusReporte')
                                  ->get();
        
        return view('desktop', [
            'totalSensores' => $totalSensores,
            'tiposSensores' => $tiposSensores,
            'ultimasLecturas' => $ultimasLecturas,
            'totalReportes' => $totalReportes,
            'reportesAbiertos' => $reportesAbiertos,
            'reportesResueltos' => $reportesResueltos,
            'lecturasPorDia' => $lecturasPorDia,
            'reportesPorEstado' => $reportesPorEstado,
        ]);
    }
}