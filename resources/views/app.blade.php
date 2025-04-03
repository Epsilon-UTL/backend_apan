<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="active-nav" content="@yield('activeNav', '')">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>APAN - @yield('title', 'Página Principal')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilos -->
    <link href="{{ asset('css/general/colores.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard/dashboard.css') }}" rel="stylesheet">
    <style>
        /* Estilos adicionales para la sidebar colapsada */
        :root {
            --transition-time: 0.3s;
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 70px;
        }

        .sidebar {
            width: var(--sidebar-width);
            transition: width var(--transition-time) ease;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width) !important;
        }

        /* Sin cambios de colapso, eliminamos toggle de la sidebar */
        .sidebar-header,
        .sidebar-menu,
        .sidebar-footer {
            transition: all var(--transition-time) ease;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            transition: margin-left var(--transition-time) ease;
        }

        /* Estilos base de la sidebar */
        .sidebar-brand {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            text-decoration: none;
        }

        .logo-image {
            width: 30px;
            height: 30px;
            margin-right: 10px;
        }

        .brand-name {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
        }

        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .user-profile {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 15px 20px;
        }

        .user-avatar i {
            font-size: 2rem;
        }

        .user-actions {
            margin-left: auto;
        }
    </style>
    <link rel="icon" href="{{ asset('images/loto_logo.png') }}" type="image/png">
</head>

<body data-theme="light">
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('desktop') }}" class="sidebar-brand">
                    <img src="{{ asset('images/loto_logo.png') }}" alt="APAN Logo" class="logo-image">
                    <span class="brand-name">APAN</span>
                </a>
            </div>

            <div class="sidebar-menu">
                <ul class="nav flex-column">
                    <li class="nav-item" data-nav="Escritorio">
                        <a class="nav-link" href="{{ route('desktop') }}">
                            <i class="fas fa-desktop"></i>
                            <span class="link-text">Escritorio</span>
                        </a>
                    </li>

                    <li class="nav-item" data-nav="Usuarios">
                        <a class="nav-link" href="{{ route('usuarios.index') }}">
                            <i class="fas fa-users"></i>
                            <span class="link-text">Usuarios</span>
                        </a>
                    </li>

                    <li class="nav-item" data-nav="Tipo Sensores">
                        <a class="nav-link" href="{{ route('tipo-sensors.index') }}">
                            <i class="fas fa-layer-group"></i>
                            <span class="link-text">Tipo Sensores</span>
                        </a>
                    </li>

                    <li class="nav-item" data-nav="Unidad Medidas">
                        <a class="nav-link" href="{{ route('unidad-medidas.index') }}">
                            <i class="fas fa-balance-scale"></i>
                            <span class="link-text">Unidad Medidas</span>
                        </a>
                    </li>

                    <li class="nav-item" data-nav="Estatus reportes">
                        <a class="nav-link" href="{{ route('estatus-reportes.index') }}">
                            <i class="fas fa-clipboard-list"></i>
                            <span class="link-text">Estatus reportes</span>
                        </a>
                    </li>

                    <li class="nav-item has-submenu" data-nav="Simulador de Datos">
                        <a class="nav-link" href="#">
                            <i class="fas fa-database"></i>
                            <span class="link-text">Simulador de Datos</span>
                            <i class="fas fa-angle-right dropdown-icon"></i>
                        </a>
                        <ul class="submenu">
                            <li class="nav-item" data-nav="Sensores">
                                <a class="nav-link" href="{{ route('sensors.index') }}">
                                    <i class="fas fa-microchip"></i>
                                    <span class="link-text">Sensores</span>
                                </a>
                            </li>
                            <li class="nav-item" data-nav="Reporte Individual">
                                <a class="nav-link" href="{{ route('simulador.reportes.create') }}">
                                    <i class="fas fa-plus-circle"></i>
                                    <span class="link-text">Reporte Individual</span>
                                </a>
                            </li>
                            <li class="nav-item" data-nav="Reportes Masivos">
                                <a class="nav-link" href="{{ route('simulador.reportes.create-massive') }}">
                                    <i class="fas fa-clone"></i>
                                    <span class="link-text">Reportes Masivos</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="sidebar-footer">
                <div class="user-profile">
                    <div class="user-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="user-info">
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        <span class="user-email">{{ Auth::user()->email }}</span>
                    </div>
                    <div class="user-actions">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-logout" title="Cerrar sesión">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navigation -->
            <nav class="top-nav">
                <div class="nav-left">
                    <h4 class="page-title">@yield('title', 'Dashboard')</h4>
                </div>

            </nav>

            <!-- Content Area -->
            <div class="content-area">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>

    <script>
        document.querySelectorAll('.has-submenu > .nav-link').forEach(item => {
            item.addEventListener('click', function (e) {
                if (this.parentElement.classList.contains('has-submenu')) {
                    e.preventDefault();
                    this.parentElement.classList.toggle('active');
                }
            });
        });
    </script>

    @yield('javascript')
</body>

</html>