@extends('app')
@section('title', 'Editar Sensor')
@section('activeNav', 'Sensores')
@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Editar Sensor</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('sensors.update', $sensor->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="valor" class="form-label">Valor</label>
                    <input type="number" step="any" name="valor" class="form-control" value="{{ $sensor->valor }}" required>
                </div>
                <div class="mb-3">
                    <label for="tipoSensor_id" class="form-label">Tipo de Sensor</label>
                    <select name="tipoSensor_id" class="form-control" required>
                        @foreach($tipoSensors as $tipoSensor)
                        <option value="{{ $tipoSensor->id }}" {{ $sensor->tipoSensor_id == $tipoSensor->id ? 'selected' : '' }}>{{ $tipoSensor->nombreSensor }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="unidadMedida_id" class="form-label">Unidad de Medida</label>
                    <select name="unidadMedida_id" class="form-control" required>
                        @foreach($unidadMedidas as $unidadMedida)
                        <option value="{{ $unidadMedida->id }}" {{ $sensor->unidadMedida_id == $unidadMedida->id ? 'selected' : '' }}>{{ $unidadMedida->unidadMedida }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" name="fecha" class="form-control" value="{{ $sensor->fecha }}" required>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('sensors.index') }}" class="btn btn-secondary">
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
