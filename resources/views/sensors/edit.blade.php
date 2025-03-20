@extends('app')
@section('title', 'Editar Sensor')
@section('activeNav', 'Sensores')
@section('content')
<div class="container">
    <h1>Editar Sensor</h1>
    <form action="{{ route('sensors.update', $sensor->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="valor">Valor</label>
            <input type="number" step="any" name="valor" class="form-control" value="{{ $sensor->valor }}" required>
        </div>
        <div class="form-group">
            <label for="tipoSensor_id">Tipo de Sensor</label>
            <select name="tipoSensor_id" class="form-control" required>
                @foreach($tipoSensors as $tipoSensor)
                <option value="{{ $tipoSensor->id }}" {{ $sensor->tipoSensor_id == $tipoSensor->id ? 'selected' : '' }}>{{ $tipoSensor->nombreSensor }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="unidadMedida_id">Unidad de Medida</label>
            <select name="unidadMedida_id" class="form-control" required>
                @foreach($unidadMedidas as $unidadMedida)
                <option value="{{ $unidadMedida->id }}" {{ $sensor->unidadMedida_id == $unidadMedida->id ? 'selected' : '' }}>{{ $unidadMedida->unidadMedida }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" class="form-control" value="{{ $sensor->fecha }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection