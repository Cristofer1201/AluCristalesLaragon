<!DOCTYPE html>
<html lang="es">

<!-- Header page (css and fonts) -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ALU Cristales Palermo - Dashboard</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">

    <!-- Custom fonts for this template-->
    <link href="{{asset('vendor/fontawesome-free/css/allpro.min.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-regular.css">

    <!-- Inter Font - Professional Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('css/sb-admin-2.min.css')}}" rel="stylesheet">

    <!--Dark mode-->
    <link href="{{asset('css/dashboardCommon.css')}}" rel="stylesheet">

    <!-- AluCristales Corporate Theme -->
    <link href="{{asset('css/alu-custom.css')}}" rel="stylesheet">

    <!-- Custom styles for this page (datatables) -->
    <link href="{{asset('vendor/datatables/datatablesB5.min.css')}}" rel="stylesheet">

    @yield('otherLinks')

    <!-- Loading Screen Styles (inline for instant render) -->
    <style>
        #loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 99999;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }
        #loading-screen.hidden {
            opacity: 0;
            visibility: hidden;
        }
        #loading-screen .spinner-wrapper {
            position: relative;
            width: 150px;
            height: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        #loading-screen .loading-logo {
            width: 70px;
            position: absolute;
            z-index: 2;
            animation: logoPulse 2s ease-in-out infinite;
        }
        @keyframes logoPulse {
            0%, 100% { transform: scale(1); opacity: 0.9; }
            50% { transform: scale(1.08); opacity: 1; }
        }
        #loading-screen .circle {
            position: absolute;
            border-radius: 50%;
            border: 3px solid transparent;
        }
        #loading-screen .circle-1 {
            width: 100%;
            height: 100%;
            border-top-color: #e74a3b;
            border-bottom-color: #e74a3b;
            animation: spin 1.2s linear infinite;
        }
        #loading-screen .circle-2 {
            width: 85%;
            height: 85%;
            border-left-color: #ffffff;
            border-right-color: #ffffff;
            animation: spin 1.6s linear infinite reverse;
        }
        #loading-screen .circle-3 {
            width: 70%;
            height: 70%;
            border-top-color: #e74a3b;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            100% { transform: rotate(360deg); }
        }
        #loading-screen .loading-text {
            margin-top: 20px;
            color: #858796;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
    </style>

</head>

<body id="page-top">

    <!-- Loading Screen -->
    <div id="loading-screen">
        <div class="spinner-wrapper">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
            <div class="circle circle-3"></div>
            <img src="{{ asset('img/Logo Alucristales.png') }}" alt="ALU Cristales" class="loading-logo">
        </div>
        <p class="loading-text">Cargando...</p>
    </div>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('dashboard')}}">
                <img src="{{asset('img/Logo Alucristales blanco.png')}}" alt="Alucristales Palermo" class="img-fluid move-up small-image" style="width: 50px;">
                <div class="sidebar-brand-text mx-3">Alu Cristales</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('dashboard')}}">
                    <i class="fa-solid fa-clipboard-list"></i>
                    <span>Resumen</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Registros
            </div>

            <!-- Nav Item - Clientes -->
            @can('dashboard.clientes.index')
            <li class="nav-item {{ request()->is('dashboard/clientes*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard.clientes.index') }}">
                    <i class="fa-solid fa-address-book"></i>
                    <span>Clientes</span>
                </a>
            </li>
            @endcan

            <!-- Nav Item - Movimientos Collapse Menu -->
            @canany(['dashboard.presupuesto.index', 'dashboard.ventas.index'])
            @php $movimientosActive = request()->is('dashboard/presupuesto*') || request()->is('dashboard/ventas*'); @endphp
            <li class="nav-item {{ $movimientosActive ? 'active' : '' }}">
                <a class="nav-link {{ $movimientosActive ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="{{ $movimientosActive ? 'true' : 'false' }}" aria-controls="collapseTwo">
                    <i class="fa-solid fa-right-left"></i>
                    <span>Movimientos</span>
                </a>
                <div id="collapseTwo" class="collapse {{ $movimientosActive ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Mantenimiento:</h6>
                        @can('dashboard.presupuesto.index')
                        <a class="collapse-item {{ request()->is('dashboard/presupuesto*') ? 'active' : '' }}" href="{{ route('dashboard.presupuesto.index') }}">
                            <i class="fa-solid fa-file-invoice"></i>
                            <span>&nbsp;Presupuesto</span>
                        </a>
                        @endcan
                        @can('dashboard.ventas.index')
                        <a class="collapse-item {{ request()->is('dashboard/ventas*') ? 'active' : '' }}" href="{{ route('dashboard.ventas.index') }}">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                            <span>&nbsp;Ventas</span>
                        </a>
                        @endcan
                    </div>
                </div>
            </li>
            @endcanany

            <!-- Nav Item - Utilities Collapse Menu -->
            @canany(['dashboard.productos.index', 'dashboard.plantilla-pdf.index'])
            @php
                $utilidadesActive = request()->is('dashboard/productos*') || request()->is('dashboard/plantilla-pdf*');
            @endphp
            <li class="nav-item {{ $utilidadesActive ? 'active' : '' }}">
                <a class="nav-link {{ $utilidadesActive ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="{{ $utilidadesActive ? 'true' : 'false' }}" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Utilidades</span>
                </a>
                <div id="collapseUtilities" class="collapse {{ $utilidadesActive ? 'show' : '' }}" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Mantener utilidades:</h6>
                        @can('dashboard.productos.index')
                        <a class="collapse-item {{ request()->is('dashboard/productos*') ? 'active' : '' }}" href="{{ route('dashboard.productos.index') }}">
                            <i class="fa-solid fa-table-columns"></i>
                            <span>&nbsp;Productos</span>
                        </a>
                        @endcan
                        @can('dashboard.plantilla-pdf.index')
                        <a class="collapse-item {{ request()->is('dashboard/plantilla-pdf*') ? 'active' : '' }}" href="{{ route('dashboard.plantilla-pdf.index') }}">
                            <i class="fa-solid fa-file-pdf"></i>
                            <span>&nbsp;Plantilla PDF</span>
                        </a>
                        @endcan
                    </div>
                </div>
            </li>
            @endcanany

            <!-- Nav Item - Users Collapse Menu -->
            @canany(['dashboard.usuarios.index', 'dashboard.roles.index'])
            <li class="nav-item {{ request()->is('dashboard/usuarios*') || request()->is('dashboard/roles*') ? 'active' : '' }}">
                <a class="nav-link {{ request()->is('dashboard/usuarios*') || request()->is('dashboard/roles*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseUsers"
                    aria-expanded="{{ request()->is('dashboard/usuarios*') || request()->is('dashboard/roles*') ? 'true' : 'false' }}" aria-controls="collapseUsers">
                    <i class="fa-solid fa-users"></i>
                    <span>Usuarios</span>
                </a>
                <div id="collapseUsers" class="collapse {{ request()->is('dashboard/usuarios*') || request()->is('dashboard/roles*') ? 'show' : '' }}" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Usuarios:</h6>
                            @can('dashboard.usuarios.index')
                                <a class="collapse-item {{ request()->is('dashboard/usuarios') ? 'active' : '' }}" href="{{route('dashboard.usuarios.index')}}">
                                    <i class="fa-solid fa-user-plus"></i>
                                    <span>&nbsp;Gestionar usuarios</span>
                                </a>
                            @endcan
                            @can('dashboard.roles.index')
                                <a class="collapse-item {{ request()->is('dashboard/roles*') ? 'active' : '' }}" href="{{route('dashboard.roles.index')}}">
                                    <i class="fa-solid fa-shield-halved"></i>
                                    <span>&nbsp;Roles y Permisos</span>
                                </a>
                            @endcan
                    </div>
                </div>
            </li>
            @endcanany

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Salir</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="text-danger fa fa-bars"></i>
                    </button>

                    <!-- Page Title -->
                    @if(isset($pageTitle))
                    <div class="d-none d-md-flex align-items-center">
                        <div>
                            <h1 class="h5 mb-0 text-gray-800 font-weight-bold">{{ $pageTitle }}</h1>
                            @if(isset($pageSubtitle))
                                <p class="mb-0 text-muted" style="font-size: 0.75rem;">{{ $pageSubtitle }}</p>
                            @endif
                        </div>
                        @if(isset($headerActions))
                            <div class="ml-3">{{ $headerActions }}</div>
                        @endif
                    </div>
                    @endif

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Dark mode -->
                        <button id="toggle" class="toggle-container">
                            <span class="slider round"></span>
                        </button>

                        <!-- Nav Item - Notifications -->
                        @auth
                        @php
                            $unreadNotifications = Auth::user()->unreadNotifications;
                            $allNotifications = Auth::user()->notifications()->take(10)->get();
                        @endphp
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                @if($unreadNotifications->count() > 0)
                                    <span class="badge badge-danger badge-counter">{{ $unreadNotifications->count() }}</span>
                                @endif
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Notificaciones
                                </h6>
                                @forelse($allNotifications as $notification)
                                    <a class="dropdown-item d-flex align-items-center {{ $notification->read_at ? '' : 'bg-light' }}" href="{{ route('dashboard.ventas.index') }}" onclick="event.preventDefault(); document.getElementById('mark-read-{{ $notification->id }}').submit();">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-success">
                                                <i class="fas fa-check text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
                                            <span class="{{ $notification->read_at ? '' : 'font-weight-bold' }}">{{ $notification->data['mensaje'] ?? 'Nueva notificacion' }}</span>
                                        </div>
                                    </a>
                                    <form id="mark-read-{{ $notification->id }}" action="{{ route('notifications.read', $notification->id) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                @empty
                                    <a class="dropdown-item text-center small text-gray-500" href="#">No hay notificaciones</a>
                                @endforelse
                                @if($allNotifications->count() > 0)
                                    <form action="{{ route('notifications.readAll') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-center small text-gray-500 border-top">Marcar todas como leidas</button>
                                    </form>
                                @endif
                            </div>
                        </li>
                        @endauth

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if(Auth::check())
                                    <span class="mr-2 d-none d-lg-inline text-right">
                                        <span class="d-block text-gray-600 small">{{ Auth::user()->name }}</span>
                                        <span class="d-block text-gray-400" style="font-size: 0.7rem;">{{ Auth::user()->roles->first()->name ?? '' }}{{ Auth::user()->tienda ? ' · ' . Auth::user()->tienda : '' }}</span>
                                    </span>
                                @else
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">No has iniciado sesion</span>
                                @endif
                                <!--<span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>-->
                                <img class="img-profile rounded-circle"
                                    src="{{asset('img/undraw_profile.svg')}}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{route('profile.edit')}}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Perfil
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Configuración
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Registro de actividad
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cerrar sesión
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                {{$slot}}
                
            </div>
            <!-- End of Main Content -->
                
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Alucristales 2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿Quieres cerrar la sesión?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Seleccione "Cerrar sesión" si está listo para finalizar su sesión actual.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="submit" data-dismiss="modal">Cancelar</button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-danger" type="submit">Cerrar sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <!-- Scripts (js) -->
    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('js/sb-admin-2.min.js')}}"></script>

    <!--Datatables Bootstrap-->
    <script src="{{asset('vendor/datatables/datatablesB5.min.js')}}"></script>
    
    <script src="{{asset('js/dashboard/dashboardCommon.js')}}"></script>

    @yield('otherScripts')

    <!-- Hide loading screen when page is ready -->
    <script>
        window.addEventListener('load', function() {
            var loader = document.getElementById('loading-screen');
            if (loader) {
                loader.classList.add('hidden');
                setTimeout(function() { loader.style.display = 'none'; }, 500);
            }
        });
    </script>

    <!-- Page level plugins -->
    <!-- <script src="vendor/chart.js/Chart.min.js"></script> -->

    <!-- Page level custom scripts -->
    <!-- <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script> -->
</body>

</html>
