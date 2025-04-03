@extends('app')
@section('title', 'Sensores')
@section('activeNav', 'Sensores')
@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Listado de Sensores</h5>
            <a href="{{ route('sensors.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus-circle"></i> Crear Sensor
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="sensors-table" class="table table-striped table-hover" style="width:100%">
                    <thead class="table-light">
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
                                <div class="d-flex gap-2">
                                    <a href="{{ route('sensors.edit', $sensor->id) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('sensors.destroy', $sensor->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este sensor?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        $('#sensors-table').DataTable({
            responsive: true,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
            },
            columnDefs: [
                { orderable: false, targets: -1 } // Deshabilitar ordenación para columna de acciones
            ]
        });

        // Inicializar tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
@endsection
