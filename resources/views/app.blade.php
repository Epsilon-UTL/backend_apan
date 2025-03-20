<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="active-nav" content="@yield('activeNav', '')">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>APAN - @yield('title', 'Página Principal')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/dashboard/cssindex.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/dashboard/sidebar.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{ asset('css/general/styles.css') }}" type="text/css">
    <link rel="icon" href="{{ asset('images/loto_logo.png') }}" type="image/png">

    <!-- Agregar estilo para el botón flotante -->
    <style>
        .notification-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: #007bff;
            color: white;
            border-radius: 30%;
            padding: 15px;
            font-size: 24px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            z-index: 1000;
        }

        .notification-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: red;
            color: white;
            font-size: 12px;
            padding: 3px 7px;
            border-radius: 50%;
            min-width: 20px;
            text-align: center;
        }

        .notification-box {
            position: fixed;
            top: 20%;
            right: 40px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
            padding: 10px;
            display: none;
            z-index: 999;
        }

        .notification-box.show {
            display: block;
        }

        .notification-box .notification-item {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .notification-box .notification-item:last-child {
            border-bottom: none;
        }
    </style>

</head>

<body class="bg-light">
    <div id="nav-bar">
        <input type="checkbox" id="nav-toggle">
        <div id="nav-header">
            <a id="nav-title" href="#">
                <img src="{{ asset('images/loto_logo.png') }}" height="50px" alt="APAN Logo" class="logo-image"> APAN
            </a>
            <label for="nav-toggle">
                <span id="nav-toggle-burger"></span>
            </label>
            <hr>
        </div>
        <div id="nav-content">
            <div class="nav-button" tabindex="0" onclick="window.location.href='{{ route('desktop') }}'"
                data-nav="Escritorio">
                <i class="fas fa-desktop"></i><span>Escritorio</span>
            </div>
            <hr>
            <div class="nav-button" tabindex="0" onclick="window.location.href='{{ route('sensors.index') }}'"
                data-nav="Sensores">
                <i class="fas fa-microchip"></i><span>Sensores</span>
            </div>
            <hr>
            <div class="nav-button" tabindex="0" onclick="window.location.href='{{ route('tipo-sensors.index') }}'"
                data-nav="Tipo Sensores">
                <i class="fas fa-layer-group"></i><span>Tipo Sensores</span>
            </div>
            <hr>
            <div class="nav-button" tabindex="0" onclick="window.location.href='{{ route('unidad-medidas.index') }}'"
                data-nav="Unidad Medidas">
                <i class="fas fa-balance-scale"></i><span>Unidad Medidas</span>
            </div>
            <hr>
            <div id="nav-content-highlight"></div>
        </div>
        <input type="checkbox" id="nav-footer-toggle">
        <div id="nav-footer">
            <div id="nav-footer-heading">
                <div id="nav-footer-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div id="nav-footer-titlebox">
                    <span id="nav-footer-title">
                        {{ strlen(Auth::user()->name) > 10 ? substr(Auth::user()->name, 0, 10) . '...' : Auth::user()->name }}
                    </span>
                    <div class="logout-container">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <i class="fas fa-sign-out-alt"></i>
                        <a id="nav-footer-subtitle" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    </div>
                </div>
                <label for="nav-footer-toggle">
                    <i class="fas fa-caret-up"></i>
                </label>
            </div>
        </div>
    </div>

    <!-- Contenido principal -->
    <main class="main" id="main-content">
        @yield('content')
    </main>


    <div class="notification-btn" onclick="toggleNotifications()">
            <i class="fas fa-bell"></i>
    </div>

    <!--     Contenedor de notificaciones -->
    <div cla    ss="notification-box" id="notificationBox">
        <div     class="notification-item">
                <strong>Notificación 1</strong>
              <  p>Descripción de la notificación.</>
        </di    v>
        <div     class="notification-item">
                <strong>Notificación 2</strong>
             <p>Descripción de la notificación.</p>
    
           </div>

   
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/dashboard/sidebar.js') }}"></script>

    <script>
        function toggleNotifications() {
            var notificationBox = document.getElementById('notificationBox');
            notificationBox.classList.toggle('show');
        }

    </script>
</body>

</html>