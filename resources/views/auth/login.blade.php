@extends('auth.auth-head')
@section('title', 'Iniciar Sesión')
@section('content')
    <div class="card card-custom" style="max-width: 800px; width: 100%; background-color: var(--color-background-light);">
        <div class="row g-0">
            <!-- Sección izquierda -->
            <div class="col-md-4 left-section d-flex flex-column align-items-center justify-content-center">
                <img src="{{ asset('images/loto_logo.png') }}" alt="Logo">
                <h2 class="mt-3" style="color: var(--color-background-light);">APAN</h2>
                <p style="color: var(--color-background-light);">APLICACIÓN DE ADMINISTRACIÓN</p>
            </div>
            <!-- Sección derecha -->
            <div class="col-md-8 form-section" style="background-color: var(--color-background-light);">
                <h2 class="text-center" style="color: var(--color-primary-dark);">Iniciar sesión</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" style="color: var(--color-primary-medium);">Correo Electrónico</label>
                        <div class="input-group">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                style="background-color: var(--color-background-light); color: var(--color-text-dark);">
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
                        <label class="form-label" style="color: var(--color-primary-medium);">Contraseña</label>
                        <div class="input-group">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password" style="background-color: var(--color-background-light); color: var(--color-text-dark);">
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

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember" style="color: var(--color-primary-medium);">Recordarme</label>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-100" style="background-color: var(--color-primary-medium); color: var(--color-text-light);">Iniciar Sesión</button>
                    </div>

                    <div class="mt-3 text-center">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="btn btn-link" style="color: var(--color-primary-dark);">¿Olvidaste tu contraseña?</a>
                        @endif
                    </div>

                    <div class="mt-3 text-center">
                        <p style="color: var(--color-primary-dark);">¿No tienes una cuenta? <a href="{{ route('register') }}" class="btn btn-link" style="color: var(--color-primary-dark);">Regístrate aquí</a></p>
                    </div>
                </form>
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