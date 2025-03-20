<?php

namespace App\Http\Controllers;

use App\Models\TipoSensor;
use Illuminate\Http\Request;

class TipoSensorController extends Controller
{
    public function index()
    {
        $tipoSensors = TipoSensor::all();
        return view('tipo_sensors.index', compact('tipoSensors'));
    }

    public function create()
    {
        return view('tipo_sensors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombreSensor' => 'required|string|max:255',
        ]);

        TipoSensor::create($request->all());
        return redirect()->route('tipo-sensors.index')->with('success', 'Tipo de Sensor creado exitosamente.');
    }

    public function show(TipoSensor $tipoSensor)
    {
        return view('tipo_sensors.show', compact('tipoSensor'));
    }

    public function edit(TipoSensor $tipoSensor)
    {
        return view('tipo_sensors.edit', compact('tipoSensor'));
    }

    public function update(Request $request, TipoSensor $tipoSensor)
    {
        $request->validate([
            'nombreSensor' => 'required|string|max:255',
        ]);

        $tipoSensor->update($request->all());
        return redirect()->route('tipo-sensors.index')->with('success', 'Tipo de Sensor actualizado exitosamente.');
    }

    public function destroy(TipoSensor $tipoSensor)
    {
        $tipoSensor->delete();
        return redirect()->route('tipo-sensors.index')->with('success', 'Tipo de Sensor eliminado exitosamente.');
    }
}
