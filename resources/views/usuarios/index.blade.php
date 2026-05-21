<x-dashboard-layout>
    <x-slot:pageTitle>Gestion de Usuarios</x-slot:pageTitle>
    <x-slot:pageSubtitle>Administra los usuarios del sistema</x-slot:pageSubtitle>
    <x-slot:headerActions>
        <button type="button" class="btn btn-success btn-sm mr-2" data-toggle="modal" data-target="#modalGuardarUsuarios">
            <i class="fa-solid fa-plus mr-1"></i>
            Nuevo Usuario
        </button>
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
            <div class="col-lg-10">
                <div class="card shadow mb-4">
                    <div class="card-header bg-success py-3">
                        <h6 class="m-0 font-weight-bold text-white">Usuarios</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tabla-usuarios" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Sede</th>
                                        <th>Creacion</th>
                                        <th>Rol</th>
                                        <th>Habilitado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align: left">
                                    @if ($usuarios->isNotEmpty())
                                        @foreach ($usuarios as $usuario)
                                            <tr>
                                                <td> {{ $usuario->name }} </td>
                                                <td> {{ $usuario->email }} </td>
                                                <td> {{ $usuario->tienda ?? '-' }} </td>
                                                <td> {{ $usuario->created_at ? $usuario->created_at->format('d/m/Y') : 'Fecha no disponible' }} </td>
                                                <td>
                                                    @foreach ($usuario->roles as $role)
                                                        {{ $role->name }}
                                                    @endforeach
                                                </td>
                                                <td class="text-center">
                                                    {!! $usuario->is_enabled
                                                        ? '<i class="fa-solid fa-check text-success"></i>'
                                                        : '<i class="fa-solid fa-xmark text-secondary"></i>' !!}
                                                </td>
                                                <td class="text-center">
                                                    <div class="row justify-content-center">
                                                        @if (!$usuario->roles->contains('name', 'Administrador'))
                                                            <div class="mx-1">
                                                                <a href='#'
                                                                    class='btn btn-warning btn-modificar'
                                                                    data-id="{{ $usuario->id }}"
                                                                    data-url1="{{ route('dashboard.usuarios.edit', $usuario->id) }}"
                                                                    data-url2="{{ route('dashboard.usuarios.update', $usuario->id) }}"
                                                                    data-toggle="modal"
                                                                    data-target="#modalEditarUsuarios">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                </a>
                                                            </div>

                                                            <div class="mx-1">
                                                                <button class='btn btn-danger btn-eliminar'
                                                                    data-user-id="{{ $usuario->id }}"
                                                                    type="button"
                                                                    data-toggle="modal"
                                                                    data-target="#modalEliminarUsuarios">
                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                </button>
                                                            </div>

                                                            <div class="mx-1">
                                                                <button
                                                                    class="btn text-white {{ $usuario->is_enabled ? 'bg-primary' : 'bg-info' }} btn-habilitar"
                                                                    data-user-id="{{ $usuario->id }}"
                                                                    data-is-enabled="{{ $usuario->is_enabled }}"
                                                                    data-toggle="modal"
                                                                    data-target="#modalHabilitarUsuarios">
                                                                    {!! $usuario->is_enabled ? "<i class='fa-solid fa-lock'></i>" : "<i class='fa-solid fa-lock-open'></i>" !!}
                                                                </button>
                                                            </div>
                                                        @endif
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

            <div class="col-lg-2">
                <div class="card shadow mb-4">
                    <div class="card-header bg-danger py-3">
                        <h6 class="m-0 font-weight-bold text-white">Roles</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tabla-roles" class="table table-hover table-striped table-bordered"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Rol</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Total: {{ $roles->count() }}</th>
                                    </tr>
                                </tfoot>
                                <tbody style="text-align: left">
                                    @if ($roles->isNotEmpty())
                                        @foreach ($roles as $rol)
                                            <tr>
                                                <td> {{ $rol->name }} </td>
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

    <div>
        <!-- Modal -->
        <div class="modal fade" id="modalGuardarUsuarios" tabindex="-1" aria-labelledby="modalLabelGuardarUsuarios"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h6 class="modal-title font-weight-bold text-white" id="modalLabelGuardarUsuarios">Registro de usuarios
                        </h6>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Validaciones -->
                    <div class="alertaValidacion alert alert-danger alert-dismissible fade show d-none" role="alert">
                        <span>Todos los campos son obligatorios.</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form class="needs-validation" novalidate id="formGuardarUsuario" method="post"
                        action="{{ route('dashboard.usuarios.store') }}">

                        @csrf

                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <label for="name" class="form-label">Nombre de usuario: </label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                    <div class="invalid-feedback">Ingrese un nombre valido</div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="email" class="form-label">Correo electronico: </label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    <div class="invalid-feedback">Ingrese un correo valido</div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="password" class="form-label">Contraseña: </label>
                                    <input type="password" class="form-control" id="password" name="password" required minlength="8" maxlength="30">
                                    <div class="invalid-feedback">La contraseña debe tener entre 8 y 30 caracteres</div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="role">Rol</label>
                                    <select id="role" name="role" class="form-control">
                                        @foreach ($roles as $role)
                                            @if ($role->name != 'Administrador')
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Seleccione un rol válido</div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="tienda">Sede</label>
                                    <select id="tienda" name="tienda" class="form-control" required>
                                        <option value="">Seleccionar sede...</option>
                                        <option value="ARAOZ 2403">ARAOZ 2403</option>
                                        <option value="GUEMES 4888">GUEMES 4888</option>
                                        <option value="PALERMO CABA">PALERMO CABA</option>
                                    </select>
                                    <div class="invalid-feedback">Seleccione una sede</div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="mx-2">
                                        <button class="btn btn-success" type="submit">
                                            <i class="fa-solid fa-floppy-disk"></i>
                                            Guardar Usuario
                                        </button>
                                    </div>
                                    <div class="mx-2">
                                        <button class="btn btn-info" type="button" onclick="fnLimpiarUsuario();">
                                            <i class="fa-solid fa-broom"></i>
                                            Limpiar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Edit-->
        <div class="modal fade" id="modalEditarUsuarios" tabindex="-1" aria-labelledby="modalLabelEditarUsuarios"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h6 class="modal-title font-weight-bold text-white" id="modalLabelEditarUsuarios">Modificar usuario
                        </h6>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Validaciones -->
                    <div class="alertaValidacion alert alert-danger alert-dismissible fade show d-none"
                        role="alert">
                        <span>Todos los campos son obligatorios.</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form class="needs-validation" novalidate id="formEditarUsuario" method="post"
                        action="{{ isset($usuario) ? route('dashboard.usuarios.update', $usuario->id) : '#' }}">

                        @csrf
                        @method('PUT')

                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <label for="edit_name" class="form-label">Nombre de usuario: </label>
                                    <input type="text" class="form-control" id="edit_name" name="name"
                                        required>
                                    <div class="invalid-feedback">Ingrese un nombre valido</div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="edit_email" class="form-label">Correo electronico: </label>
                                    <input type="email" class="form-control" id="edit_email" name="email"
                                        required>
                                    <div class="invalid-feedback">Ingrese un correo valido</div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="edit_role" class="form-label">Rol:</label>
                                    <select id="edit_role" name="role" class="form-control" required>
                                        @foreach ($roles as $role)
                                            @if ($role->name != 'Administrador')
                                                <option value="{{ $role->id }}"
                                                    {{ $role->id == old('role', $usuario->roles->first()->id ?? '') ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Seleccione un rol válido</div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="edit_tienda" class="form-label">Sede:</label>
                                    <select id="edit_tienda" name="tienda" class="form-control" required>
                                        <option value="">Seleccionar sede...</option>
                                        <option value="ARAOZ 2403">ARAOZ 2403</option>
                                        <option value="GUEMES 4888">GUEMES 4888</option>
                                        <option value="PALERMO CABA">PALERMO CABA</option>
                                    </select>
                                    <div class="invalid-feedback">Seleccione una sede</div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="mx-2">
                                        <button class="btn btn-warning" type="submit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            Modificar Usuario
                                        </button>
                                    </div>
                                    <div class="mx-2">
                                        <button class="btn btn-info" type="button" onclick="fnLimpiarUsuario();">
                                            <i class="fa-solid fa-broom"></i>
                                            Limpiar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Delete-->
        <div class="modal fade" id="modalEliminarUsuarios" tabindex="-1"
            aria-labelledby="modalLabelEliminarUsuarios" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h6 class="modal-title font-weight-bold text-white" id="modalLabelEliminarUsuarios">Eliminar
                            usuario
                        </h6>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <div>¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.</div>
                            </div>
                        </div>
                    </div>
                    
                    <form action="{{ isset($usuario) ? route('dashboard.usuarios.destroy', $usuario->id) : '#' }}" method="post"
                        id="formEliminarUsuario">

                        @csrf
                        @method('DELETE')

                        <div class="modal-footer">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="mx-2">
                                        <button class="btn btn-danger" type="submit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            Eliminar Usuario
                                        </button>
                                    </div>
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Enable -->
        <div class="modal fade" id="modalHabilitarUsuarios" tabindex="-1" role="dialog"
            aria-labelledby="modalLabelHabilitarUsuarios" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabelHabilitarUsuarios">¿Quieres cambiar el estado del usuario?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div>Si está deshabilitado, tendrá este ícono
                            <a class="btn btn-info">
                                <i class="fa-solid fa-lock-open"></i>
                            </a>
                            lo que significa que pasará a habilitarse y podrá iniciar su gestión.
                        </div>
                        <br>
                        <div>Si está habilitado, tendrá este ícono
                            <a class="btn btn-primary">
                                <i class="fa-solid fa-lock"></i>
                            </a>
                            lo que significa que pasará a deshabilitarse y no podrá iniciar su gestión.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                        <form action="" method="POST" id="formHabilitarUsuario">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-primary" type="submit">Cambiar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('otherScripts')
        <script src="{{ asset('js/dashboard/rulesMantenimientoUsuarios.js') }}"></script>
    @endsection
    <!-- /.container-fluid -->
</x-dashboard-layout>
