@extends('app')
@section('title', 'Crear Usuario')
@section('activeNav', 'Usuarios')
@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Crear Nuevo Usuario</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('usuarios.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" required placeholder="Nombre del Usuario">
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" required placeholder="Correo Electrónico">
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" required placeholder="Contraseña">
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
