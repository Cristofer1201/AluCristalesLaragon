<x-dashboard-layout>
    <x-slot:pageTitle>Ventas</x-slot:pageTitle>
    <x-slot:pageSubtitle>Presupuestos generados y su estado actual</x-slot:pageSubtitle>

    <div class="container-fluid py-4 container-darkmode">

        <!-- Resumen Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Presupuestos</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $presupuestos->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-file-invoice fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Aceptados</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $presupuestos->where('estado', 'aceptado')->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-circle-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Entregados</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $presupuestos->where('estado', 'entregado')->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-paper-plane fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Monto Total</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">$ {{ number_format($presupuestos->sum('total'), 0, ',', '.') }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Presupuestos -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header bg-danger py-3">
                        <h6 class="m-0 font-weight-bold text-white">
                            <i class="fa-solid fa-file-invoice-dollar mr-2"></i>Presupuestos Generados
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tabla-ventas" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nro</th>
                                        <th>Fecha</th>
                                        <th>Cliente</th>
                                        <th>Creado por</th>
                                        <th>Cantidad</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($presupuestos as $presupuesto)
                                        <tr>
                                            <td>
                                                <span class="font-weight-bold text-primary">{{ $presupuesto->numero }}</span>
                                            </td>
                                            <td>{{ $presupuesto->fecha->format('d/m/Y') }}</td>
                                            <td>
                                                <div class="font-weight-bold">{{ $presupuesto->cliente_nombre ?? '-' }}</div>
                                                @if($presupuesto->cliente_telefono)
                                                    <small class="text-muted">
                                                        <i class="fa-solid fa-phone fa-xs"></i> {{ $presupuesto->cliente_telefono }}
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="font-weight-bold">{{ $presupuesto->usuario->name ?? '-' }}</div>
                                                @if($presupuesto->usuario)
                                                    <small class="text-muted">{{ $presupuesto->usuario->tienda ?? '' }}</small>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-pill badge-light border px-3 py-1">
                                                    {{ $presupuesto->items->count() }}
                                                </span>
                                            </td>
                                            <td class="font-weight-bold">
                                                $ {{ number_format($presupuesto->total, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $estado = $presupuesto->estado ?? 'borrador';
                                                    $estadoConfig = [
                                                        'generado'  => ['class' => 'badge-secondary', 'label' => 'Generado'],
                                                        'aceptado'  => ['class' => 'badge-success',   'label' => 'Aceptado'],
                                                        'rechazado' => ['class' => 'badge-danger',    'label' => 'Rechazado'],
                                                        'entregado' => ['class' => '',                'label' => 'Entregado'],
                                                    ];
                                                    $cfg = $estadoConfig[$estado] ?? ['class' => 'badge-secondary', 'label' => ucfirst($estado)];
                                                @endphp
                                                <div class="dropdown d-inline-block">
                                                    <span class="badge {{ $cfg['class'] }} px-3 py-1 dropdown-toggle"
                                                          style="cursor:pointer; font-size:0.8rem; {{ $estado === 'entregado' ? 'background-color:#6f42c1;color:#fff;' : '' }}"
                                                          data-toggle="dropdown"
                                                          aria-haspopup="true"
                                                          aria-expanded="false">
                                                        {{ $cfg['label'] }}
                                                    </span>
                                                    <div class="dropdown-menu dropdown-menu-right shadow">
                                                        <h6 class="dropdown-header">Cambiar estado</h6>
                                                        @foreach(['generado' => 'Generado', 'aceptado' => 'Aceptado', 'rechazado' => 'Rechazado', 'entregado' => 'Entregado'] as $val => $label)
                                                            <a class="dropdown-item btn-cambiar-estado-inline {{ $estado === $val ? 'active' : '' }}"
                                                               href="#"
                                                               data-id="{{ $presupuesto->id }}"
                                                               data-estado="{{ $val }}"
                                                               data-url="{{ route('dashboard.ventas.updateEstado', $presupuesto->id) }}">
                                                                {{ $label }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('dashboard.presupuesto.descargar-pdf', $presupuesto->id) }}"
                                                       class="btn btn-danger btn-sm mx-1"
                                                       title="Descargar PDF">
                                                        <i class="fa-solid fa-file-pdf"></i>
                                                    </a>
                                                    <a href="{{ route('dashboard.presupuesto.index', ['editar' => $presupuesto->id]) }}"
                                                       class="btn btn-warning btn-sm mx-1"
                                                       title="Editar presupuesto">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <button class="btn btn-dark btn-sm mx-1 btn-eliminar-presupuesto"
                                                        data-id="{{ $presupuesto->id }}"
                                                        data-numero="{{ $presupuesto->numero }}"
                                                        data-toggle="modal"
                                                        data-target="#modalEliminarPresupuesto"
                                                        title="Eliminar">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Eliminar Presupuesto -->
    <div class="modal fade" id="modalEliminarPresupuesto" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title font-weight-bold text-white">
                        <i class="fa-solid fa-trash-can mr-2"></i>Eliminar Presupuesto
                    </h6>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Estas seguro de que deseas eliminar el presupuesto <strong id="eliminarNumero"></strong>?</p>
                    <p class="text-muted small">Esta accion no se puede deshacer. Se eliminaran todos los items asociados.</p>
                </div>
                <form id="formEliminarPresupuesto" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-danger" type="submit">
                            <i class="fa-solid fa-trash-can mr-1"></i>
                            Eliminar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @section('otherScripts')
    <script>
        $(document).ready(function() {
            $('#tabla-ventas').DataTable({
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por pagina",
                    "zeroRecords": "No se encontraron presupuestos",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "«",
                        "last": "»",
                        "next": "›",
                        "previous": "‹"
                    }
                },
                "order": [[0, 'desc']],
                "columnDefs": [
                    { "orderable": false, "targets": [7] }
                ]
            });

            // Cambiar estado inline desde dropdown
            $(document).on('click', '.btn-cambiar-estado-inline', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                var estado = $(this).data('estado');
                var token = '{{ csrf_token() }}';

                var $form = $('<form method="POST" style="display:none;"></form>')
                    .attr('action', url)
                    .append('<input name="_token" value="' + token + '">')
                    .append('<input name="_method" value="PUT">')
                    .append('<input name="estado" value="' + estado + '">');

                $('body').append($form);
                $form.submit();
            });

            // Modal eliminar
            $('.btn-eliminar-presupuesto').on('click', function() {
                var id = $(this).data('id');
                var numero = $(this).data('numero');

                $('#eliminarNumero').text('Nro ' + numero);

                var actionUrl = "{{ route('dashboard.ventas.destroy', ':id') }}".replace(':id', id);
                $('#formEliminarPresupuesto').attr('action', actionUrl);
            });
        });
    </script>
    @endsection
</x-dashboard-layout>
