@extends('app')
@section('title', 'Estatus de Reportes')
@section('activeNav', 'Estatus Reportes')
@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Listado de Estatus de Reportes</h5>
            <a href="{{ route('estatus-reportes.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus-circle"></i> Nuevo Estatus
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="estatus-table" class="table table-striped table-hover" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($estatusReportes as $estatus)
                        <tr>
                            <td>{{ $estatus->id }}</td>
                            <td>{{ $estatus->estatus }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('estatus-reportes.edit', $estatus->id) }}" 
                                       class="btn btn-sm btn-warning" 
                                       data-bs-toggle="tooltip" 
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('estatus-reportes.destroy', $estatus->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger" 
                                                data-bs-toggle="tooltip" 
                                                title="Eliminar"
                                                onclick="return confirm('¿Estás seguro de eliminar este estatus?')">
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
        $('#estatus-table').DataTable({
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