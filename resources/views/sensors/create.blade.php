@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Sensor</h1>
    <form action="{{ route('sensors.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="valor">Valor</label>
            <input type="number" step="any" name="valor" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="tipoSensor_id">Tipo de Sensor</label>
            <select name="tipoSensor_id" class="form-control" required>
                @foreach($tipoSensors as $tipoSensor)
                <option value="{{ $tipoSensor->id }}">{{ $tipoSensor->nombreSensor }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="unidadMedida_id">Unidad de Medida</label>
            <select name="unidadMedida_id" class="form-control" required>
                @foreach($unidadMedidas as $unidadMedida)
                <option value="{{ $unidadMedida->id }}">{{ $unidadMedida->unidadMedida }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection