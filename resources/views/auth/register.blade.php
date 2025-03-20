@extends('auth.auth-head')
@section('title', 'Registro')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-custom" style="max-width: 800px; width: 100%;">
                    <div class="row g-0">
                        <!-- Sección izquierda -->
                        <div class="col-md-4 left-section d-flex flex-column align-items-center justify-content-center">
                            <img src="{{ asset('images/loto_logo.png') }}" alt="Logo">
                            <h2 class="mt-3">APAN</h2>
                            <p>APLICACIÓN DE ADMINISTRACIÓN</p>
                        </div>
                        <!-- Sección derecha -->
                        <div class="col-md-8 form-section">
                            <h2 class="text-center text-danger">Registro</h2>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre</label>
                                    <div class="input-group">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo Electrónico</label>
                                    <div class="input-group">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <div class="input-group">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                        <span class="input-group-text">
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
                                    <label for="password-confirm" class="form-label">Confirmar Contraseña</label>
                                    <div class="input-group">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        <span class="input-group-text">
                                            <i class="fas fa-eye" id="toggleConfirmPassword" style="cursor: pointer;"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Registrarse</button>
                                </div>

                                <div class="mt-3 text-center">
                                    <p>¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="btn btn-link">Inicia sesión aquí</a></p>
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
        </script>
    @endsection
@endsection