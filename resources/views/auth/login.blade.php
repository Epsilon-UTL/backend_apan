@extends('auth.auth-head')
@section('title', 'Iniciar Sesión')
@section('content')
    <div class="login-container">
        <div class="card card-custom">
            <div class="row g-0">
                <!-- Sección izquierda -->
                <div class="col-md-5 left-section">
                    <img src="{{ asset('images/loto_logo.png') }}" alt="Logo APAN" class="img-fluid">
                    <h2>APAN</h2>
                    <p>Aplicación de Administración</p>
                    <div class="mt-4">
                        <div class="d-flex justify-content-center">
                            <span class="wave-divider"></span>
                        </div>
                    </div>
                </div>
                
                <!-- Sección derecha -->
                <div class="col-md-7 form-section">
                    <h2>Iniciar sesión</h2>
                    <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <div class="input-group wave-effect">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                    placeholder="tu@email.com">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Contraseña</label>
                            <div class="input-group wave-effect">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password" placeholder="••••••••">
                                <span class="input-group-text">
                                    <i class="fas fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                                </span>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Recordarme</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt me-2"></i> Iniciar Sesión
                            </button>
                        </div>

                        <div class="mt-4 text-center">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="btn btn-link">¿Olvidaste tu contraseña?</a>
                            @endif
                        </div>

                        <div class="mt-3 text-center">
                            <p class="text-muted">¿No tienes una cuenta? 
                                <a href="{{ route('register') }}" class="btn btn-link">Regístrate aquí</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @section('javascript')
        <script>
            // Toggle password visibility
            document.getElementById("togglePassword").addEventListener("click", function () {
                const passwordField = document.getElementById("password");
                const icon = this;
                
                if (passwordField.type === "password") {
                    passwordField.type = "text";
                    icon.classList.remove("fa-eye");
                    icon.classList.add("fa-eye-slash");
                } else {
                    passwordField.type = "password";
                    icon.classList.remove("fa-eye-slash");
                    icon.classList.add("fa-eye");
                }
            });

            // Validación de formulario
            (function () {
                'use strict';
                
                const forms = document.querySelectorAll('.needs-validation');
                
                Array.from(forms).forEach(form => {
                    form.addEventListener('submit', event => {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        
                        form.classList.add('was-validated');
                    }, false);
                });
            })();
        </script>
    @endsection
@endsection