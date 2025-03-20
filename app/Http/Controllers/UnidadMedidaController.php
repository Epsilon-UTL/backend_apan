<?php

namespace App\Http\Controllers;

use App\Models\UnidadMedida;
use Illuminate\Http\Request;

class UnidadMedidaController extends Controller
{
    public function index()
    {
        $unidadMedidas = UnidadMedida::all();
        return view('unidad_medidas.index', compact('unidadMedidas'));
    }

    public function create()
    {
        return view('unidad_medidas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'unidadMedida' => 'required|string|max:255',
        ]);

        UnidadMedida::create($request->all());
        return redirect()->route('unidad-medidas.index')->with('success', 'Unidad de Medida creada exitosamente.');
    }

    public function show(UnidadMedida $unidadMedida)
    {
        return view('unidad_medidas.show', compact('unidadMedida'));
    }

    public function edit(UnidadMedida $unidadMedida)
    {
        return view('unidad_medidas.edit', compact('unidadMedida'));
    }

    public function update(Request $request, UnidadMedida $unidadMedida)
    {
        $request->validate([
            'unidadMedida' => 'required|string|max:255',
        ]);

        $unidadMedida->update($request->all());
        return redirect()->route('unidad-medidas.index')->with('success', 'Unidad de Medida actualizada exitosamente.');
    }

    public function destroy(UnidadMedida $unidadMedida)
    {
        $unidadMedida->delete();
        return redirect()->route('unidad-medidas.index')->with('success', 'Unidad de Medida eliminada exitosamente.');
    }
}
