@extends('app')
@section('title', 'Editar Sensor')
@section('activeNav', 'Tipo Sensores')
@section('content')
<div class="container">
    <h1>Editar Tipo de Sensor</h1>
    <form action="{{ route('tipo-sensors.update', $tipoSensor->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nombreSensor">Nombre del Sensor</label>
            <input type="text" name="nombreSensor" class="form-control" value="{{ $tipoSensor->nombreSensor }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection