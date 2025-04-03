@extends('app')
@section('title', 'Crear Unidad de Medida')
@section('activeNav', 'Unidad Medidas')
@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Crear Nueva Unidad de Medida</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('unidad-medidas.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="unidadMedida" class="form-label">Nombre de la Unidad</label>
                    <input type="text" name="unidadMedida" class="form-control" required
                           placeholder="Ej: Kilogramos, Litros, Metros...">
                    @error('unidadMedida')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('unidad-medidas.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection