@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sensores</h1>
    <a href="{{ route('sensors.create') }}" class="btn btn-primary">Crear Sensor</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Valor</th>
                <th>Tipo de Sensor</th>
                <th>Unidad de Medida</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sensors as $sensor)
            <tr>
                <td>{{ $sensor->id }}</td>
                <td>{{ $sensor->valor }}</td>
                <td>{{ $sensor->tipoSensor->nombreSensor }}</td>
                <td>{{ $sensor->unidadMedida->unidadMedida }}</td>
                <td>{{ $sensor->fecha }}</td>
                <td>
                    <a href="{{ route('sensors.edit', $sensor->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('sensors.destroy', $sensor->id) }}" method="POST" style="display:inline;">
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