<?php

namespace App\Http\Controllers;

use App\Models\EstatusReporte;
use App\Models\Reporte;
use App\Models\Sensor;
use App\Models\User;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    //
    public function index()
    {
        $report = Reporte::with(['sensor_id','usuario_id','descripcion','estatus_id','fecha'])->get();  
        return view('reporte.index', compact('report'));
    }

    public function create()
    {
        $sensor = Sensor::all();
        $usuario = User::all();
        $estatus = EstatusReporte::all();
        return view('reporte.create', compact('Sensores','Users','Estatus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sensor_id'=> 'required|exists:sensor_id',
            'usuario_id'=> 'required|exists:usuario_id',
            'descripcion'=> 'required|string',
            'estatus_id'=> 'required|exists:estatus_id',
            'fecha'=> 'required|date'
            ]);

            Reporte::create($request->all());
            return redirect()->route('reporte.index')->with('success','Reporte creado exitosamente');
    }

    public function show($id)
    {
        return view('reporte.show', compact('reporte'));
    }

    public function edit(Reporte $report)
    {
        $sensor = Sensor::all();
        $usuario = User::all();
        $estatus = EstatusReporte::all();
        return view('reporte.edit', compact('reporte','Sensores','Users','Estatus'));
    }

    public function update(Request $request,Reporte $report)
    {
        $request->validate([
            'sensor_id'=> 'required|exists:sensor_id',
            'usuario_id'=> 'required|exists:usuario_id',
            'descripcion'=> 'required|string',
            'estatus_id'=> 'required|exists:estatus_id',
            'fecha'=> 'required|date'
            ]);
            $report->update($request->all());
            return redirect()->route('reporte.index')->with('success','Reporte actualizado');
    }

    public function destroy(Reporte $report)
    {
        $report->delete();
        return redirect()->route('reporte.index')->with('success','Reporte eliminado exitosamente');
    }
}
