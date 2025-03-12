@extends('app')
@section('title', content: 'Tipos de Sensores')
@section('activeNav', 'Tipo Sensores')
@section('content')
<div class="container">
    <h1>Tipos de Sensores</h1>
    <a href="{{ route('tipo-sensors.create') }}" class="btn btn-primary">Crear Tipo de Sensor</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tipoSensors as $tipoSensor)
            <tr>
                <td>{{ $tipoSensor->id }}</td>
                <td>{{ $tipoSensor->nombreSensor }}</td>
                <td>
                    <a href="{{ route('tipo-sensors.edit', $tipoSensor->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('tipo-sensors.destroy', $tipoSensor->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection