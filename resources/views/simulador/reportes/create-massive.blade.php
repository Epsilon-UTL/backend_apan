@extends('app')

@section('content')
<div class="container">
    <h2>Crear Reportes Masivos</h2>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('simulador.reportes.storeMassive') }}">
        @csrf
        
        <div class="form-group">
            <label for="cantidad">Cantidad de reportes a generar</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" max="1000" value="10" required>
        </div>
        
        <div class="form-group">
            <label for="sensor_id">Sensor (opcional - si no se selecciona, será aleatorio)</label>
            <select class="form-control" id="sensor_id" name="sensor_id">
                <option value="">Aleatorio</option>
                @foreach($sensores as $sensor)
                    <option value="{{ $sensor->id }}">{{ $sensor->id }} - {{ $sensor->tipoSensor->nombreSensor }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="usuario_id">Usuario (opcional - si no se selecciona, será aleatorio)</label>
            <select class="form-control" id="usuario_id" name="usuario_id">
                <option value="">Aleatorio</option>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}">{{ $usuario->name }} ({{ $usuario->email }})</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="estatus_id">Estatus (opcional - si no se selecciona, será aleatorio)</label>
            <select class="form-control" id="estatus_id" name="estatus_id">
                <option value="">Aleatorio</option>
                @foreach($estatus as $est)
                    <option value="{{ $est->id }}">{{ $est->estatus }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="rango_fechas">Rango de fechas (opcional)</label>
            <input type="text" class="form-control" id="rango_fechas" name="rango_fechas" placeholder="YYYY-MM-DD - YYYY-MM-DD">
        </div>
        
        <button type="submit" class="btn btn-primary">Generar Reportes</button>
        <a href="{{ route('simulador.reportes.create') }}" class="btn btn-secondary">Ir a inserción individual</a>
    </form>
</div>

<script>
    // Inicializar el datepicker para el rango de fechas
    $(function() {
        $('#rango_fechas').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
    });
</script>
@endsection