@extends('auth.auth-head')
@section('title', 'Registro')
@section('content')

    <link rel="stylesheet" href="{{asset('css/login/auth.css')}}" type="text/css">
    
    <div class="register-container">
        <div class="card card-custom">
            <div class="row g-0">
                <!-- Sección izquierda -->
                <div class="col-md-4 left-section">
                    <div class="logo-container">
                        <img src="{{ asset('images/loto_logo.png') }}" alt="Logo APAN" class="img-fluid">
                        <h2>APAN</h2>
                        <p>Aplicación de Administración</p>
                    </div>
                </div>
                
                <!-- Sección derecha -->
                <div class="col-md-8 form-section">
                    <h2 class="text-center mb-4">Crear Cuenta</h2>
                    <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nombre Completo</label>
                                <div class="input-group wave-effect">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                        placeholder="Tu nombre">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <div class="input-group wave-effect">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                        name="email" value="{{ old('email') }}" required autocomplete="email"
                                        placeholder="tu@email.com">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <div class="input-group wave-effect">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                        name="password" required autocomplete="new-password" placeholder="••••••••">
                                    <span class="input-group-text toggle-password">
                                        <i class="fas fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                                    </span>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="password-strength mt-2">
                                    <div class="progress">
                                        <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                                    </div>
                                    <small class="text-muted" id="passwordStrengthText">Seguridad: 0%</small>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password-confirm" class="form-label">Confirmar Contraseña</label>
                                <div class="input-group wave-effect">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input id="password-confirm" type="password" class="form-control" 
                                        name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                                    <span class="input-group-text toggle-password">
                                        <i class="fas fa-eye" id="toggleConfirmPassword" style="cursor: pointer;"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        Acepto los <a href="#" class="text-primary">términos y condiciones</a>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <button type="submit" class="btn btn-primary w-100 py-2">
                                    <i class="fas fa-user-plus me-2"></i> Registrarse
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 text-center">
                                <p class="mb-0">¿Ya tienes una cuenta? 
                                    <a href="{{ route('login') }}" class="text-primary fw-bold">Inicia sesión aquí</a>
                                </p>
                            </div>
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

            // Toggle confirm password visibility
            document.getElementById("toggleConfirmPassword").addEventListener("click", function () {
                const confirmPasswordField = document.getElementById("password-confirm");
                const icon = this;
                
                if (confirmPasswordField.type === "password") {
                    confirmPasswordField.type = "text";
                    icon.classList.remove("fa-eye");
                    icon.classList.add("fa-eye-slash");
                } else {
                    confirmPasswordField.type = "password";
                    icon.classList.remove("fa-eye-slash");
                    icon.classList.add("fa-eye");
                }
            });

            // Password strength indicator
            document.getElementById("password").addEventListener("input", function() {
                const password = this.value;
                const strengthBar = document.getElementById("passwordStrength");
                const strengthText = document.getElementById("passwordStrengthText");
                
                // Reset
                strengthBar.style.width = "0%";
                strengthBar.classList.remove("bg-danger", "bg-warning", "bg-success");
                
                if (password.length === 0) {
                    strengthText.textContent = "Seguridad: 0%";
                    return;
                }
                
                // Calculate strength
                let strength = 0;
                
                // Length
                if (password.length > 7) strength += 25;
                if (password.length > 11) strength += 25;
                
                // Complexity
                if (/[A-Z]/.test(password)) strength += 15;
                if (/[0-9]/.test(password)) strength += 15;
                if (/[^A-Za-z0-9]/.test(password)) strength += 20;
                
                // Update UI
                strength = Math.min(strength, 100);
                strengthBar.style.width = strength + "%";
                strengthText.textContent = `Seguridad: ${strength}%`;
                
                if (strength < 40) {
                    strengthBar.classList.add("bg-danger");
                } else if (strength < 70) {
                    strengthBar.classList.add("bg-warning");
                } else {
                    strengthBar.classList.add("bg-success");
                }
            });

            // Form validation
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