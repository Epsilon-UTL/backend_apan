@extends('app')
@section('title', 'Crear Unidad de Medida')
@section('activeNav', 'Unidad Medidas')
@section('content')
<div class="container">
    <h1>Crear Unidad de Medida</h1>
    <form action="{{ route('unidad-medidas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="unidadMedida">Unidad de Medida</label>
            <input type="text" name="unidadMedida" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection