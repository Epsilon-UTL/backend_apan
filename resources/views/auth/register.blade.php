@extends('auth.auth-head')
@section('title', 'Registro')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-custom" style="max-width: 800px; width: 100%; background-color: var(--color-background-light);">
                    <div class="row g-0">
                        <!-- Sección izquierda -->
                        <div class="col-md-4 left-section d-flex flex-column align-items-center justify-content-center" style="background-color: var(--color-primary-dark);">
                            <img src="{{ asset('images/loto_logo.png') }}" alt="Logo">
                            <h2 class="mt-3" style="color: var(--color-background-light);">APAN</h2>
                            <p style="color: var(--color-background-light);">APLICACIÓN DE ADMINISTRACIÓN</p>
                        </div>
                        <!-- Sección derecha -->
                        <div class="col-md-8 form-section" style="background-color: var(--color-background-light);">
                            <h2 class="text-center" style="color: var(--color-primary-dark);">Registro</h2>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="name" class="form-label" style="color: var(--color-primary-medium);">Nombre</label>
                                    <div class="input-group">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus style="background-color: var(--color-background-light); color: var(--color-text-dark);">
                                        <span class="input-group-text" style="background-color: var(--color-primary-light);">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label" style="color: var(--color-primary-medium);">Correo Electrónico</label>
                                    <div class="input-group">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" style="background-color: var(--color-background-light); color: var(--color-text-dark);">
                                        <span class="input-group-text" style="background-color: var(--color-primary-light);">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label" style="color: var(--color-primary-medium);">Contraseña</label>
                                    <div class="input-group">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" style="background-color: var(--color-background-light); color: var(--color-text-dark);">
                                        <span class="input-group-text" style="background-color: var(--color-primary-light);">
                                            <i class="fas fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                                        </span>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password-confirm" class="form-label" style="color: var(--color-primary-medium);">Confirmar Contraseña</label>
                                    <div class="input-group">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" style="background-color: var(--color-background-light); color: var(--color-text-dark);">
                                        <span class="input-group-text" style="background-color: var(--color-primary-light);">
                                            <i class="fas fa-eye" id="toggleConfirmPassword" style="cursor: pointer;"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary w-100" style="background-color: var(--color-primary-medium); color: var(--color-text-light);">Registrarse</button>
                                </div>

                                <div class="mt-3 text-center">
                                    <p style="color: var(--color-primary-dark);">¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="btn btn-link" style="color: var(--color-primary-dark);">Inicia sesión aquí</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('javascript')
        <script>
            document.getElementById("togglePassword").addEventListener("click", function () {
                let passwordField = document.getElementById("password");
                if (passwordField.type === "password") {
                    passwordField.type = "text";
                    this.classList.remove("fa-eye");
                    this.classList.add("fa-eye-slash");
                } else {
                    passwordField.type = "password";
                    this.classList.remove("fa-eye-slash");
                    this.classList.add("fa-eye");
                }
            });

            document.getElementById("toggleConfirmPassword").addEventListener("click", function () {
                let confirmPasswordField = document.getElementById("password-confirm");
                if (confirmPasswordField.type === "password") {
                    confirmPasswordField.type = "text";
                    this.classList.remove("fa-eye");
                    this.classList.add("fa-eye-slash");
                } else {
                    confirmPasswordField.type = "password";
                    this.classList.remove("fa-eye-slash");
                    this.classList.add("fa-eye");
                }
            });
        </script>
    @endsection
@endsection