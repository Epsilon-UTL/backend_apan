@extends('app')
@section('title', 'Editar Tipo de Sensor')
@section('activeNav', 'Tipo Sensores')
@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Editar Tipo de Sensor</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('tipo-sensors.update', $tipoSensor->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nombreSensor" class="form-label">Nombre del Tipo de Sensor</label>
                    <input type="text" name="nombreSensor" class="form-control" 
                           value="{{ old('nombreSensor', $tipoSensor->nombreSensor) }}" required>
                    @error('nombreSensor')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('tipo-sensors.index') }}" class="btn btn-secondary">
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