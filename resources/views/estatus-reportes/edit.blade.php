@extends('app')
@section('title', 'Editar Estatus de Reporte')
@section('activeNav', 'Estatus Reportes')
@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Editar Estatus de Reporte</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('estatus-reportes.update', $estatusReporte->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="estatus" class="form-label">Nombre del Estatus</label>
                    <input type="text" name="estatus" class="form-control" 
                           value="{{ old('estatus', $estatusReporte->estatus) }}" required>
                    @error('estatus')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('estatus-reportes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection