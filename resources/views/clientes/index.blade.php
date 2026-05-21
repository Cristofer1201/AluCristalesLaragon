<x-dashboard-layout>
    <x-slot:pageTitle>Clientes Registrados</x-slot:pageTitle>
    <x-slot:pageSubtitle>Administra los clientes del sistema</x-slot:pageSubtitle>
    <x-slot:headerActions>
        @can('dashboard.clientes.store')
        <button type="button" class="btn btn-success btn-sm mr-2" data-toggle="modal" data-target="#modalGuardarCliente">
            <i class="fa-solid fa-plus mr-1"></i>
            Nuevo Cliente
        </button>
        @endcan
        <div class="btn-group">
            <div class="dropright">
                <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-download mr-1"></i>
                    Exportar
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">
                        <i class="fa-solid fa-file-pdf mr-2"></i>PDF
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fa-solid fa-file-csv mr-2"></i>CSV
                    </a>
                </div>
            </div>
        </div>
    </x-slot:headerActions>

    <!-- Begin Page Content -->
    <div class="container-fluid py-4 container-darkmode">

        @if (session('errors'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header bg-danger py-3">
                        <h6 class="m-0 font-weight-bold text-white">
                            <i class="fa-solid fa-address-book mr-2"></i>Listado de Clientes
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tabla-clientes" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Direccion</th>
                                        <th>Telefono</th>
                                        <th>Email</th>
                                        <th>Fax</th>
                                        <th>Fecha Registro</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align: left">
                                    @if ($clientes->isNotEmpty())
                                        @foreach ($clientes as $cliente)
                                            <tr>
                                                <td>{{ $cliente->id }}</td>
                                                <td>{{ $cliente->nombre }}</td>
                                                <td>{{ $cliente->direccion ?? '-' }}</td>
                                                <td>{{ $cliente->telefono ?? '-' }}</td>
                                                <td>{{ $cliente->email ?? '-' }}</td>
                                                <td>{{ $cliente->fax ?? '-' }}</td>
                                                <td>{{ $cliente->created_at ? $cliente->created_at->format('d/m/Y') : '-' }}</td>
                                                <td class="text-center">
                                                    <div class="row justify-content-center">
                                                        @can('dashboard.clientes.edit')
                                                        <div class="mx-1">
                                                            <button class='btn btn-warning btn-sm btn-editar-cliente'
                                                                data-id="{{ $cliente->id }}"
                                                                data-nombre="{{ $cliente->nombre }}"
                                                                data-direccion="{{ $cliente->direccion }}"
                                                                data-telefono="{{ $cliente->telefono }}"
                                                                data-email="{{ $cliente->email }}"
                                                                data-fax="{{ $cliente->fax }}"
                                                                data-toggle="modal"
                                                                data-target="#modalEditarCliente">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </button>
                                                        </div>
                                                        @endcan

                                                        @can('dashboard.clientes.destroy')
                                                        <div class="mx-1">
                                                            <button class='btn btn-danger btn-sm btn-eliminar-cliente'
                                                                data-id="{{ $cliente->id }}"
                                                                data-nombre="{{ $cliente->nombre }}"
                                                                type="button"
                                                                data-toggle="modal"
                                                                data-target="#modalEliminarCliente">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </button>
                                                        </div>
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Guardar Cliente -->
    <div class="modal fade" id="modalGuardarCliente" tabindex="-1" aria-labelledby="modalLabelGuardarCliente" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h6 class="modal-title font-weight-bold text-white" id="modalLabelGuardarCliente">
                        <i class="fa-solid fa-user-plus mr-2"></i>Registrar Nuevo Cliente
                    </h6>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="needs-validation" novalidate id="formGuardarCliente" method="post"
                    action="{{ route('dashboard.clientes.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                                <div class="invalid-feedback">Ingrese el nombre del cliente</div>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo electronico:</label>
                                <input type="email" class="form-control" id="email" name="email">
                                <div class="invalid-feedback">Ingrese un correo valido</div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label for="direccion" class="form-label">Direccion:</label>
                                <input type="text" class="form-control" id="direccion" name="direccion">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Telefono:</label>
                                <input type="text" class="form-control" id="telefono" name="telefono">
                            </div>
                            <div class="col-md-6">
                                <label for="fax" class="form-label">Fax:</label>
                                <input type="text" class="form-control" id="fax" name="fax">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-success" type="submit">
                            <i class="fa-solid fa-floppy-disk mr-1"></i>
                            Guardar Cliente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Cliente -->
    <div class="modal fade" id="modalEditarCliente" tabindex="-1" aria-labelledby="modalLabelEditarCliente" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h6 class="modal-title font-weight-bold text-white" id="modalLabelEditarCliente">
                        <i class="fa-solid fa-pen-to-square mr-2"></i>Modificar Cliente
                    </h6>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="needs-validation" novalidate id="formEditarCliente" method="post" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="edit_nombre" class="form-label">Nombre: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
                                <div class="invalid-feedback">Ingrese el nombre del cliente</div>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_email" class="form-label">Correo electronico:</label>
                                <input type="email" class="form-control" id="edit_email" name="email">
                                <div class="invalid-feedback">Ingrese un correo valido</div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label for="edit_direccion" class="form-label">Direccion:</label>
                                <input type="text" class="form-control" id="edit_direccion" name="direccion">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="edit_telefono" class="form-label">Telefono:</label>
                                <input type="text" class="form-control" id="edit_telefono" name="telefono">
                            </div>
                            <div class="col-md-6">
                                <label for="edit_fax" class="form-label">Fax:</label>
                                <input type="text" class="form-control" id="edit_fax" name="fax">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-warning" type="submit">
                            <i class="fa-solid fa-pen-to-square mr-1"></i>
                            Modificar Cliente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Eliminar Cliente -->
    <div class="modal fade" id="modalEliminarCliente" tabindex="-1" aria-labelledby="modalLabelEliminarCliente" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title font-weight-bold text-white" id="modalLabelEliminarCliente">
                        <i class="fa-solid fa-trash-can mr-2"></i>Eliminar Cliente
                    </h6>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>¿Estas seguro de que deseas eliminar al cliente <strong id="nombreClienteEliminar"></strong>?</p>
                    <p class="text-muted small">Esta accion no se puede deshacer.</p>
                </div>

                <form action="" method="post" id="formEliminarCliente">
                    @csrf
                    @method('DELETE')
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-danger" type="submit">
                            <i class="fa-solid fa-trash-can mr-1"></i>
                            Eliminar Cliente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @section('otherScripts')
    <script>
        $(document).ready(function() {
            // Inicializar DataTables
            $('#tabla-clientes').DataTable({
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por pagina",
                    "zeroRecords": "No se encontraron clientes",
                    "info": "Mostrando pagina _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                "order": [[0, 'desc']]
            });

            // Configurar modal de editar
            $('.btn-editar-cliente').on('click', function() {
                var id = $(this).data('id');
                var nombre = $(this).data('nombre');
                var direccion = $(this).data('direccion');
                var telefono = $(this).data('telefono');
                var email = $(this).data('email');
                var fax = $(this).data('fax');

                $('#edit_nombre').val(nombre);
                $('#edit_direccion').val(direccion);
                $('#edit_telefono').val(telefono);
                $('#edit_email').val(email);
                $('#edit_fax').val(fax);

                var actionUrl = "{{ route('dashboard.clientes.update', ':id') }}".replace(':id', id);
                $('#formEditarCliente').attr('action', actionUrl);
            });

            // Configurar modal de eliminar
            $('.btn-eliminar-cliente').on('click', function() {
                var id = $(this).data('id');
                var nombre = $(this).data('nombre');

                $('#nombreClienteEliminar').text(nombre);

                var actionUrl = "{{ route('dashboard.clientes.destroy', ':id') }}".replace(':id', id);
                $('#formEliminarCliente').attr('action', actionUrl);
            });
        });
    </script>
    @endsection
</x-dashboard-layout>
