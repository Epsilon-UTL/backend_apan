<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use App\Models\TipoSensor;
use App\Models\UnidadMedida;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    public function index()
    {
        $sensors = Sensor::with(['tipoSensor', 'unidadMedida'])->get();
        return view('sensors.index', compact('sensors'));
    }

    public function create()
    {
        $tipoSensors = TipoSensor::all();
        $unidadMedidas = UnidadMedida::all();
        return view('sensors.create', compact('tipoSensors', 'unidadMedidas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'unidadMedida_id' => 'required|exists:unidad_medida,id',
            'valor' => 'required|numeric',
            'tipoSensor_id' => 'required|exists:tipo_sensor,id',
            'fecha' => 'required|date',
        ]);

        Sensor::create($request->all());
        return redirect()->route('sensors.index')->with('success', 'Sensor creado exitosamente.');
    }

    public function show(Sensor $sensor)
    {
        return view('sensors.show', compact('sensor'));
    }

    public function edit(Sensor $sensor)
    {
        $tipoSensors = TipoSensor::all();
        $unidadMedidas = UnidadMedida::all();
        return view('sensors.edit', compact('sensor', 'tipoSensors', 'unidadMedidas'));
    }

    public function update(Request $request, Sensor $sensor)
    {
        $request->validate([
            'unidadMedida_id' => 'required|exists:unidad_medida,id',
            'valor' => 'required|numeric',
            'tipoSensor_id' => 'required|exists:tipo_sensor,id',
            'fecha' => 'required|date',
        ]);

        $sensor->update($request->all());
        return redirect()->route('sensors.index')->with('success', 'Sensor actualizado exitosamente.');
    }

    public function destroy(Sensor $sensor)
    {
        $sensor->delete();
        return redirect()->route('sensors.index')->with('success', 'Sensor eliminado exitosamente.');
    }
}