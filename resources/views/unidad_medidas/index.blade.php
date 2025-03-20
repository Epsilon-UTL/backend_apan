@extends('app')
@section('title', 'Unidades de Medida')
@section('activeNav', 'Unidad Medidas')
@section('content')
<div class="container">
    <h1>Unidades de Medida</h1>
    <a href="{{ route('unidad-medidas.create') }}" class="btn btn-primary">Crear Unidad de Medida</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Unidad de Medida</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($unidadMedidas as $unidadMedida)
            <tr>
                <td>{{ $unidadMedida->id }}</td>
                <td>{{ $unidadMedida->unidadMedida }}</td>
                <td>
                    <a href="{{ route('unidad-medidas.edit', $unidadMedida->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('unidad-medidas.destroy', $unidadMedida->id) }}" method="POST" style="display:inline;">
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