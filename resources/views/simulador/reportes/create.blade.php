@extends('app')

@section('content')
<div class="container">
    <h2>Crear Reporte Individual</h2>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('simulador.reportes.store') }}">
        @csrf
        
        <div class="form-group">
            <label for="sensor_id">Sensor</label>
            <select class="form-control" id="sensor_id" name="sensor_id" required>
                <option value="">Seleccione un sensor</option>
                @foreach($sensores as $sensor)
                    <option value="{{ $sensor->id }}">{{ $sensor->id }} - {{ $sensor->tipoSensor->nombreSensor }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="usuario_id">Usuario</label>
            <select class="form-control" id="usuario_id" name="usuario_id" required>
                <option value="">Seleccione un usuario</option>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}">{{ $usuario->name }} ({{ $usuario->email }})</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
        </div>
        
        <div class="form-group">
            <label for="estatus_id">Estatus</label>
            <select class="form-control" id="estatus_id" name="estatus_id" required>
                <option value="">Seleccione un estatus</option>
                @foreach($estatus as $est)
                    <option value="{{ $est->id }}">{{ $est->estatus }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="fecha">Fecha (opcional)</label>
            <input type="datetime-local" class="form-control" id="fecha" name="fecha">
        </div>
        
        <button type="submit" class="btn btn-primary">Crear Reporte</button>
        <a href="{{ route('simulador.reportes.create-massive') }}" class="btn btn-secondary">Ir a inserción masiva</a>
    </form>
</div>
@endsection