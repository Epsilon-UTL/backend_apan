@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Unidad de Medida</h1>
    <form action="{{ route('unidad-medidas.update', $unidadMedida->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="unidadMedida">Unidad de Medida</label>
            <input type="text" name="unidadMedida" class="form-control" value="{{ $unidadMedida->unidadMedida }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection