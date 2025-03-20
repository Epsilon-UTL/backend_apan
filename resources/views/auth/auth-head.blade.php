<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'APAN - Página Principal')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/general/styles.css') }}" type="text/css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .card-custom {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        .left-section {
            background-color: var(--azul-principal);
            color: white;
            text-align: center;
            padding: 30px;
        }
        .left-section img {
            width: 150px;
            height: auto;
        }
        .form-section {
            padding: 30px;
        }
        .btn-primary {
            background-color: var(--azul-principal);
            border: none;
        }
        .btn-primary:hover {
            background-color: var(--azul-oscuro);
        }
        .input-group-text {
            background: transparent;
            border: none;
        }
        .text-danger {
            color: var(--azul-principal) !important;
        }
        .btn-link {
            color: var(--azul-principal);
        }
        .btn-link:hover {
            color: var(--azul-oscuro);
        }
    </style>
    <link rel="icon" href="{{ asset('images/loto_logo.png') }}" type="image/png">
</head>
<body>
    @yield('content')
</body>
</html>