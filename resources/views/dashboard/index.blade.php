<x-dashboard-layout>

    @section('otherLinks')
    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
    <style>
        /* Dashboard Styles */
        .stat-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--alu-shadow-md) !important;
        }
        .stat-card .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        .stat-card:hover .stat-icon {
            transform: scale(1.1);
        }
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.2;
        }
        .stat-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .stat-change {
            font-size: 0.75rem;
            font-weight: 500;
        }
        .stat-change.positive {
            color: var(--alu-success);
        }
        .stat-change.negative {
            color: var(--alu-primary);
        }

        /* Activity Timeline */
        .activity-item {
            position: relative;
            padding-left: 2rem;
            padding-bottom: 1.25rem;
            border-left: 2px solid var(--alu-gray-200);
            margin-left: 0.5rem;
        }
        .activity-item:last-child {
            border-left-color: transparent;
            padding-bottom: 0;
        }
        .activity-item::before {
            content: '';
            position: absolute;
            left: -6px;
            top: 0;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--alu-primary);
            border: 2px solid white;
            box-shadow: 0 0 0 2px var(--alu-primary-light);
        }
        .activity-item.success::before {
            background: var(--alu-success);
            box-shadow: 0 0 0 2px var(--alu-success-light);
        }
        .activity-item.info::before {
            background: var(--alu-info);
            box-shadow: 0 0 0 2px var(--alu-info-light);
        }
        .activity-item.warning::before {
            background: var(--alu-warning);
            box-shadow: 0 0 0 2px var(--alu-warning-light);
        }

        /* Client Avatar */
        .client-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
            color: white;
        }

        /* Calendar Styles */
        #calendar {
            font-size: 0.8rem;
        }
        .fc .fc-toolbar-title {
            font-size: 1rem;
            font-weight: 600;
        }
        .fc .fc-button-primary {
            background: var(--alu-primary) !important;
            border: none !important;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
        .fc .fc-button-primary:hover {
            background: var(--alu-primary-hover) !important;
        }
        .fc .fc-daygrid-day.fc-day-today {
            background: var(--alu-primary-light) !important;
        }
        .fc .fc-daygrid-day-number {
            font-size: 0.8rem;
            padding: 4px 8px;
        }

        /* Quick Action Buttons */
        .quick-action {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.25rem;
            border-radius: var(--alu-radius-lg);
            border: 2px dashed var(--alu-gray-200);
            transition: all 0.3s ease;
            text-decoration: none;
            color: var(--alu-gray-600);
        }
        .quick-action:hover {
            border-color: var(--alu-primary);
            background: var(--alu-primary-light);
            color: var(--alu-primary);
            transform: translateY(-3px);
            text-decoration: none;
        }
        .quick-action i {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        .quick-action span {
            font-size: 0.75rem;
            font-weight: 600;
            text-align: center;
        }

        /* Chart Container */
        .chart-container {
            position: relative;
            height: 250px;
        }

        /* Alert Card */
        .alert-card {
            border-radius: var(--alu-radius);
            padding: 1rem;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }
        .alert-card.alert-info-card {
            background: var(--alu-info-light);
            border-left: 4px solid var(--alu-info);
        }
        .alert-card.alert-warning-card {
            background: var(--alu-warning-light);
            border-left: 4px solid var(--alu-warning);
        }
        .alert-card.alert-success-card {
            background: var(--alu-success-light);
            border-left: 4px solid var(--alu-success);
        }
        .alert-card .alert-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* Table improvements */
        .table-dashboard {
            font-size: 0.875rem;
        }
        .table-dashboard tbody tr {
            transition: all 0.2s ease;
        }
        .table-dashboard tbody tr:hover {
            background: var(--alu-gray-50);
        }

        /* Welcome Banner */
        .welcome-banner {
            background: linear-gradient(135deg, var(--alu-primary) 0%, var(--alu-primary-dark) 100%);
            border-radius: var(--alu-radius-lg);
            padding: 1.5rem 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .welcome-banner::before {
            content: '';
            position: absolute;
            right: -50px;
            top: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }
        .welcome-banner::after {
            content: '';
            position: absolute;
            right: 50px;
            bottom: -80px;
            width: 150px;
            height: 150px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }
    </style>
    @endsection

    <!-- Page Content -->
    <div class="container-fluid py-4">

        <!-- Welcome Banner -->
        <div class="welcome-banner mb-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-1" style="font-weight: 700;">Bienvenido, {{ Auth::user()->name }}!</h2>
                    <p class="mb-0 opacity-75">Aqui tienes un resumen de la actividad de tu sistema.</p>
                </div>
                <div class="col-md-4 text-md-right">
                    <span class="d-inline-block px-3 py-2 rounded" style="background: rgba(255,255,255,0.2);">
                        <i class="fa-solid fa-calendar-days mr-2"></i>
                        {{ now()->translatedFormat('l, d F Y') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Stats Cards Row -->
        <div class="row">
            <!-- Total Clientes Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="{{route('dashboard.clientes.index')}}" class="text-decoration-none">
                    <div class="card stat-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="stat-label text-muted mb-1">Clientes Registrados</p>
                                    <h3 class="stat-value text-gray-800">{{ $stats['totalClientes'] }}</h3>
                                    <p class="stat-change positive mb-0 mt-2">
                                        <i class="fa-solid fa-arrow-trend-up mr-1"></i>
                                        <span>Activos</span>
                                    </p>
                                </div>
                                <div class="stat-icon" style="background: var(--alu-primary-light);">
                                    <i class="fa-solid fa-address-book fa-lg" style="color: var(--alu-primary);"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Total Usuarios Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="{{route('dashboard.usuarios.index')}}" class="text-decoration-none">
                    <div class="card stat-card h-100" >
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="stat-label text-muted mb-1">Total Usuarios</p>
                                    <h3 class="stat-value text-gray-800">{{ $stats['totalUsuarios'] }}</h3>
                                    <p class="stat-change positive mb-0 mt-2">
                                        <i class="fa-solid fa-user-check mr-1"></i>
                                        <span>{{ $stats['usuariosActivos'] }} activos</span>
                                    </p>
                                </div>
                                <div class="stat-icon" style="background: var(--alu-success-light);">
                                    <i class="fa-solid fa-users fa-lg" style="color: var(--alu-success);"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Productos Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="{{route('dashboard.productos.index')}}" class="text-decoration-none">
                    <div class="card stat-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="stat-label text-muted mb-1">Productos</p>
                                    <h3 class="stat-value text-gray-800">{{ $stats['totalProductos'] }}</h3>
                                    <p class="stat-change mb-0 mt-2 text-muted">
                                        <i class="fa-solid fa-box-open mr-1"></i>
                                        <span>En inventario</span>
                                    </p>
                                </div>
                                <div class="stat-icon" style="background: var(--alu-info-light);">
                                    <i class="fa-solid fa-box fa-lg" style="color: var(--alu-info);"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Presupuestos Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="{{route('dashboard.presupuesto.index')}}" class="text-decoration-none">
                    <div class="card stat-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="stat-label text-muted mb-1">Presupuestos</p>
                                    <h3 class="stat-value text-gray-800">{{ $stats['presupuestosEsteMes'] }}</h3>
                                    <p class="stat-change mb-0 mt-2 text-muted">
                                        <i class="fa-solid fa-file-invoice mr-1"></i>
                                        <span>Este mes</span>
                                    </p>
                                </div>
                                <div class="stat-icon" style="background: var(--alu-warning-light);">
                                    <i class="fa-solid fa-file-invoice fa-lg" style="color: var(--alu-warning);"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Main Content Row -->
        <div class="row">
            <!-- Chart Section -->
            <div class="col-xl-8 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold" style="color: var(--alu-gray-700);">
                            <i class="fa-solid fa-chart-line mr-2" style="color: var(--alu-primary);"></i>
                            Estadisticas de Crecimiento
                        </h6>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-toggle="dropdown">
                                Ultimos 6 meses
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Ultimos 6 meses</a>
                                <a class="dropdown-item" href="#">Este ano</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="growthChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alerts & Notifications -->
            <div class="col-xl-4 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold" style="color: var(--alu-gray-700);">
                            <i class="fa-solid fa-bell mr-2" style="color: var(--alu-warning);"></i>
                            Notificaciones
                        </h6>
                        <span class="badge" style="background: var(--alu-primary-light); color: var(--alu-primary);">3</span>
                    </div>
                    <div class="card-body">
                        <div class="alert-card alert-info-card">
                            <div class="alert-icon" style="background: var(--alu-info);">
                                <i class="fa-solid fa-info text-white"></i>
                            </div>
                            <div>
                                <strong class="d-block" style="color: var(--alu-info);">Sistema actualizado</strong>
                                <small class="text-muted">El sistema esta funcionando correctamente.</small>
                            </div>
                        </div>
                        <div class="alert-card alert-success-card">
                            <div class="alert-icon" style="background: var(--alu-success);">
                                <i class="fa-solid fa-check text-white"></i>
                            </div>
                            <div>
                                <strong class="d-block" style="color: var(--alu-success);">Backup completado</strong>
                                <small class="text-muted">Ultimo respaldo: {{ now()->subHours(2)->diffForHumans() }}</small>
                            </div>
                        </div>
                        <div class="alert-card alert-warning-card">
                            <div class="alert-icon" style="background: var(--alu-warning);">
                                <i class="fa-solid fa-exclamation text-white"></i>
                            </div>
                            <div>
                                <strong class="d-block" style="color: var(--alu-warning);">Revision pendiente</strong>
                                <small class="text-muted">Hay presupuestos sin revisar.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Content Row -->
        <div class="row">
            <!-- Recent Clients -->
            <div class="col-xl-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold" style="color: var(--alu-gray-700);">
                            <i class="fa-solid fa-user-plus mr-2" style="color: var(--alu-success);"></i>
                            Clientes Recientes
                        </h6>
                        @can('dashboard.clientes.index')
                        <a href="{{ route('dashboard.clientes.index') }}" class="btn btn-sm btn-outline-danger">
                            Ver todos <i class="fa-solid fa-arrow-right ml-1"></i>
                        </a>
                        @endcan
                    </div>
                    <div class="card-body p-0">
                        @if($clientesRecientes->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-dashboard mb-0">
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Contacto</th>
                                        <th>Registro</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($clientesRecientes as $cliente)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="client-avatar mr-3" style="background: linear-gradient(135deg, var(--alu-primary) 0%, var(--alu-primary-hover) 100%);">
                                                    {{ strtoupper(substr($cliente->nombre, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <strong>{{ $cliente->nombre }}</strong>
                                                    @if($cliente->direccion)
                                                    <br><small class="text-muted">{{ Str::limit($cliente->direccion, 25) }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($cliente->telefono)
                                            <small><i class="fa-solid fa-phone mr-1 text-muted"></i>{{ $cliente->telefono }}</small>
                                            @endif
                                            @if($cliente->email)
                                            <br><small><i class="fa-solid fa-envelope mr-1 text-muted"></i>{{ Str::limit($cliente->email, 20) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $cliente->created_at->diffForHumans() }}</small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-5">
                            <i class="fa-solid fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No hay clientes registrados aun</p>
                            @can('dashboard.clientes.store')
                            <a href="{{ route('dashboard.clientes.index') }}" class="btn btn-sm btn-danger">
                                <i class="fa-solid fa-plus mr-1"></i> Agregar Cliente
                            </a>
                            @endcan
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Activity Timeline -->
            <div class="col-xl-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold" style="color: var(--alu-gray-700);">
                            <i class="fa-solid fa-clock-rotate-left mr-2" style="color: var(--alu-info);"></i>
                            Actividad Reciente
                        </h6>
                    </div>
                    <div class="card-body">
                        @if($actividadReciente->isNotEmpty())
                        @foreach($actividadReciente as $actividad)
                        <div class="activity-item {{ $actividad['color'] }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong>{{ $actividad['titulo'] }}</strong>
                                    <p class="mb-0 text-muted small">{{ $actividad['descripcion'] }}</p>
                                </div>
                                <small class="text-muted">{{ $actividad['fecha']->diffForHumans() }}</small>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="text-center py-4">
                            <i class="fa-solid fa-clipboard-list fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No hay actividad reciente</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Third Content Row -->
        <div class="row">
            <!-- Quick Actions -->
            <div class="col-xl-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold" style="color: var(--alu-gray-700);">
                            <i class="fa-solid fa-bolt mr-2" style="color: var(--alu-primary);"></i>
                            Accesos Rapidos
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <a href="{{ route('dashboard.presupuesto.index') }}" class="quick-action">
                                    <i class="fa-solid fa-file-invoice"></i>
                                    <span>Nuevo Presupuesto</span>
                                </a>
                            </div>
                            @can('dashboard.clientes.index')
                            <div class="col-6 mb-3">
                                <a href="{{ route('dashboard.clientes.index') }}" class="quick-action">
                                    <i class="fa-solid fa-user-plus"></i>
                                    <span>Agregar Cliente</span>
                                </a>
                            </div>
                            @endcan
                            <div class="col-6 mb-3">
                                <a href="{{ route('dashboard.productos.index') }}" class="quick-action">
                                    <i class="fa-solid fa-box"></i>
                                    <span>Ver Productos</span>
                                </a>
                            </div>
                            @can('dashboard.usuarios.index')
                            <div class="col-6 mb-3">
                                <a href="{{ route('dashboard.usuarios.index') }}" class="quick-action">
                                    <i class="fa-solid fa-users-gear"></i>
                                    <span>Gestionar Usuarios</span>
                                </a>
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendar -->
            <div class="col-xl-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold" style="color: var(--alu-gray-700);">
                            <i class="fa-solid fa-calendar-days mr-2" style="color: var(--alu-info);"></i>
                            Calendario
                        </h6>
                    </div>
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>

            <!-- System Info -->
            <div class="col-xl-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold" style="color: var(--alu-gray-700);">
                            <i class="fa-solid fa-circle-info mr-2" style="color: var(--alu-info);"></i>
                            Informacion del Sistema
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">
                                    <i class="fa-solid fa-user mr-2"></i>Usuario actual
                                </span>
                                <span class="font-weight-bold">{{ Auth::user()->name }}</span>
                            </div>
                        </div>
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">
                                    <i class="fa-solid fa-envelope mr-2"></i>Correo
                                </span>
                                <span class="font-weight-bold small">{{ Auth::user()->email }}</span>
                            </div>
                        </div>
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">
                                    <i class="fa-solid fa-shield mr-2"></i>Rol
                                </span>
                                <span class="badge" style="background: var(--alu-primary-light); color: var(--alu-primary);">
                                    {{ Auth::user()->roles->first()->name ?? 'Sin rol' }}
                                </span>
                            </div>
                        </div>
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">
                                    <i class="fa-solid fa-circle-check mr-2"></i>Estado
                                </span>
                                @if(Auth::user()->is_enabled)
                                <span class="badge" style="background: var(--alu-success-light); color: var(--alu-success);">
                                    <i class="fa-solid fa-check-circle mr-1"></i>Activo
                                </span>
                                @else
                                <span class="badge" style="background: var(--alu-warning-light); color: var(--alu-warning);">
                                    <i class="fa-solid fa-clock mr-1"></i>Pendiente
                                </span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">
                                    <i class="fa-solid fa-calendar-plus mr-2"></i>Miembro desde
                                </span>
                                <span class="font-weight-bold">{{ Auth::user()->created_at->format('d M, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End Page Content -->

    @section('otherScripts')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Growth Chart
            const ctx = document.getElementById('growthChart').getContext('2d');
            const chartData = @json($chartData);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [
                        {
                            label: 'Clientes',
                            data: chartData.clientes,
                            borderColor: '#dc2626',
                            backgroundColor: 'rgba(220, 38, 38, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#dc2626',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7
                        },
                        {
                            label: 'Usuarios',
                            data: chartData.usuarios,
                            borderColor: '#059669',
                            backgroundColor: 'rgba(5, 150, 105, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#059669',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            cornerRadius: 8,
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                stepSize: 1
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });

            // Mini Calendar
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'today'
                },
                height: 'auto',
                dayMaxEvents: 2,
                events: [
                    // Eventos de ejemplo - puedes cargar desde API
                    {
                        title: 'Revision de presupuestos',
                        start: new Date().toISOString().split('T')[0],
                        color: '#dc2626'
                    }
                ]
            });
            calendar.render();
        });
    </script>
    @endsection

</x-dashboard-layout>
