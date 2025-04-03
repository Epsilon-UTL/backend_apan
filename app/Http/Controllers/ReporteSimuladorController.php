<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use App\Models\Sensor;
use App\Models\User;
use App\Models\EstatusReporte;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ReporteSimuladorController extends Controller
{
    /**
     * Muestra el formulario para crear reportes
     */
    public function create()
    {
        $sensores = Sensor::all();
        $usuarios = User::all();
        $estatus = EstatusReporte::all();
        
        return view('simulador.reportes.create', compact('sensores', 'usuarios', 'estatus'));
    }

    /**
     * Almacena un nuevo reporte individual
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sensor_id' => 'required|exists:sensor,id',
            'usuario_id' => 'required|exists:users,id',
            'descripcion' => 'required|string|max:500',
            'estatus_id' => 'required|exists:estatus_reportes,id',
            'fecha' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $fecha = $request->fecha ? $request->fecha : Carbon::now();

        Reporte::create([
            'sensor_id' => $request->sensor_id,
            'usuario_id' => $request->usuario_id,
            'descripcion' => $request->descripcion,
            'estatus_id' => $request->estatus_id,
            'fecha' => $fecha
        ]);

        return redirect()->route('simulador.reportes.create')
            ->with('success', 'Reporte creado exitosamente!');
    }

    /**
     * Muestra el formulario para inserción masiva
     */
    public function createMassive()
    {
        $sensores = Sensor::all();
        $usuarios = User::all();
        $estatus = EstatusReporte::all();
        
        return view('simulador.reportes.create-massive', compact('sensores', 'usuarios', 'estatus'));
    }

    /**
     * Almacena múltiples reportes
     */
    public function storeMassive(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cantidad' => 'required|integer|min:1|max:1000',
            'sensor_id' => 'nullable|exists:sensor,id',
            'usuario_id' => 'nullable|exists:users,id',
            'estatus_id' => 'nullable|exists:estatus_reportes,id',
            'rango_fechas' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $cantidad = $request->cantidad;
        $reportes = [];

        // Procesar rango de fechas si se proporciona
        $fechas = $this->procesarRangoFechas($request->rango_fechas, $cantidad);

        for ($i = 0; $i < $cantidad; $i++) {
            $reportes[] = [
                'sensor_id' => $request->sensor_id ?? $this->getRandomSensorId(),
                'usuario_id' => $request->usuario_id ?? $this->getRandomUserId(),
                'descripcion' => $this->generarDescripcionAleatoria(),
                'estatus_id' => $request->estatus_id ?? $this->getRandomEstatusId(),
                'fecha' => $fechas[$i] ?? Carbon::now()->subDays(rand(0, 30))->format('Y-m-d H:i:s'),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        // Inserción masiva
        Reporte::insert($reportes);

        return redirect()->route('simulador.reportes.create-massive')
            ->with('success', "$cantidad reportes creados exitosamente!");
    }

    /**
     * Genera IDs aleatorios de sensores
     */
    private function getRandomSensorId()
    {
        return Sensor::inRandomOrder()->first()->id;
    }

    /**
     * Genera IDs aleatorios de usuarios
     */
    private function getRandomUserId()
    {
        return User::inRandomOrder()->first()->id;
    }

    /**
     * Genera IDs aleatorios de estatus
     */
    private function getRandomEstatusId()
    {
        return EstatusReporte::inRandomOrder()->first()->id;
    }

    /**
     * Genera descripciones aleatorias para los reportes
     */
    private function generarDescripcionAleatoria()
    {
        $problemas = [
            "Fallo en la lectura de datos",
            "Valores fuera de rango",
            "Sensor no responde",
            "Interferencia detectada",
            "Necesita calibración",
            "Lecturas inconsistentes",
            "Conexión intermitente",
            "Alerta de mantenimiento",
            "Reemplazo recomendado",
            "Error en la transmisión"
        ];

        return $problemas[array_rand($problemas)] . " - " . Carbon::now()->format('Y-m-d H:i:s');
    }

    /**
     * Procesa el rango de fechas para distribución
     */
    private function procesarRangoFechas($rango, $cantidad)
    {
        if (empty($rango)) {
            return [];
        }

        $partes = explode(' - ', $rango);
        if (count($partes) !== 2) {
            return [];
        }

        $inicio = Carbon::createFromFormat('Y-m-d', trim($partes[0]));
        $fin = Carbon::createFromFormat('Y-m-d', trim($partes[1]));

        if ($inicio->greaterThan($fin)) {
            return [];
        }

        $diferenciaDias = $inicio->diffInDays($fin);
        $paso = $diferenciaDias / ($cantidad - 1);

        $fechas = [];
        for ($i = 0; $i < $cantidad; $i++) {
            $fecha = $inicio->copy()->addDays($i * $paso);
            $fechas[] = $fecha->format('Y-m-d H:i:s');
        }

        return $fechas;
    }
}