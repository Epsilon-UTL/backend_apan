<?php

namespace App\Http\Controllers;

use App\Models\EstatusReporte;
use Illuminate\Http\Request;

class EstatusReporteController extends Controller
{
    public function index()
    {
        $estatusReportes = EstatusReporte::all();
        return view('estatus-reportes.index', compact('estatusReportes'));
    }

    public function create()
    {
        return view('estatus-reportes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'estatus' => 'required|string|max:255|unique:estatus_reportes,estatus'
        ]);

        EstatusReporte::create($request->all());

        return redirect()->route('estatus-reportes.index')
                         ->with('success', 'Estatus creado exitosamente.');
    }

    public function edit(EstatusReporte $estatusReporte)
    {
        return view('estatus-reportes.edit', compact('estatusReporte'));
    }

    public function update(Request $request, EstatusReporte $estatusReporte)
    {
        $request->validate([
            'estatus' => 'required|string|max:255|unique:estatus_reportes,estatus,'.$estatusReporte->id
        ]);

        $estatusReporte->update($request->all());

        return redirect()->route('estatus-reportes.index')
                         ->with('success', 'Estatus actualizado exitosamente.');
    }

    public function destroy(EstatusReporte $estatusReporte)
    {
        $estatusReporte->delete();

        return redirect()->route('estatus-reportes.index')
                         ->with('success', 'Estatus eliminado exitosamente.');
    }
}