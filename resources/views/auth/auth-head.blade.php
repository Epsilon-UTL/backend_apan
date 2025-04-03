<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="APAN - Aplicación de Administración">
    <title>@yield('title', 'APAN - Página Principal')</title>
    <!-- Preload de fuentes y recursos críticos -->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" as="style">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" as="style">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/general/colores.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/general/styles.css') }}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/login/login.css')}}" type="text/css">
    <link rel="icon" href="{{ asset('images/loto_logo.png') }}" type="image/png">
    <!-- Fuente moderna -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="theme-transition">
    @yield('content')

    <script>
        function applySystemTheme() {
            const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const html = document.documentElement;
            
            if (!html.classList.contains('theme-transition')) {
                html.classList.add('theme-transition');
            }
            
            if (prefersDarkScheme) {
                html.setAttribute('data-theme', 'dark');
            } else {
                html.setAttribute('data-theme', 'light');
            }
        }

        document.addEventListener('DOMContentLoaded', applySystemTheme);

        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', applySystemTheme);
    </script>

    @yield('javascript')
</body>
</html>