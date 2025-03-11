<?php

namespace App\Http\Controllers;

use App\Models\EstatusReporte;
use Illuminate\Http\Request;

class EstatusReporteController extends Controller
{
    //
    public function index()
    {
        $estatus = EstatusReporte::all();
        return view("estatus_reporte.index", compact("Estatus"));
    }

    public function create()
    {
        return view("estatus_reporte.index");
    }

    public function store(Request $request)
    {
        $request->validate([
            "estatus"=> "required|string|max:255",
        ]);
        EstatusReporte::create($request->all());
        return redirect()->route("estatus_reporte.index")->with("success","Tipo de estatus creado exitosamente");
    }

    public function show(EstatusReporte $estatusReporte)
    {
        return view("estatus_reporte.show", compact("Estatus"));
    }

    public function edit(EstatusReporte $estatusReporte)
    {
        return view("estatus_reporte.edit", compact("Estatus"));
    }

    public function update(Request $request, EstatusReporte $estatusReporte)
    {
        $request->validate([
            "estatus"=> "required|string|max:255",
            ]);
        $estatusReporte->update($request->all());
        return redirect()->route("estatus_reporte.index")->with("success","Tipo de estatus actualizado exitosamente");
    }

    public function destroy(EstatusReporte $estatusReporte)
    {
        $estatusReporte->delete();
        return redirect()->route("estatus_reporte.index")->with("success","Tipo de estatus eliminado exitosamente");
    }
}
