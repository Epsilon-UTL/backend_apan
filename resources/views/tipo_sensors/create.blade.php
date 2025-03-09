@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Tipo de Sensor</h1>
    <form action="{{ route('tipo-sensors.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombreSensor">Nombre del Sensor</label>
            <input type="text" name="nombreSensor" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection