@extends('app')
@section('title', 'Usuarios')
@section('activeNav', 'Usuarios')
@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Listado de Usuarios</h5>
            <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus-circle"></i> Nuevo Usuario
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="usuarios-table" class="table table-striped table-hover" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo Electrónico</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id }}</td>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>
                                <span class="badge {{ $usuario->role === 'administrador' ? 'bg-primary' : 'bg-info' }}">
                                    {{ $usuario->role === 'administrador' ? 'Administrador' : 'Usuario' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $usuario->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $usuario->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('usuarios.edit', $usuario->id) }}" 
                                       class="btn btn-sm btn-warning" 
                                       data-bs-toggle="tooltip" 
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger" 
                                                data-bs-toggle="tooltip" 
                                                title="Eliminar"
                                                onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
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
        $('#usuarios-table').DataTable({
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
