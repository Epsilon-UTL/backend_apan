<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'APAN - Página Principal')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/general/styles.css') }}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/login/login.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/general/colores.css')}}" type="text/css">
    <link rel="icon" href="{{ asset('images/loto_logo.png') }}" type="image/png">
</head>
<body>
    @yield('content')

    <script>
        // Función para aplicar el tema según la preferencia del sistema
        function applySystemTheme() {
            const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)').matches;

            if (prefersDarkScheme) {
                document.documentElement.setAttribute('data-theme', 'dark');
            } else {
                document.documentElement.setAttribute('data-theme', 'light');
            }
        }

        // Aplicar el tema al cargar la página
        applySystemTheme();

        // Escuchar cambios en la preferencia de color del sistema
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', applySystemTheme);
    </script>

    @yield('javascript')
</body>
</html>