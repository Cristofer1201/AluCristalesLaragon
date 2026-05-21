<x-dashboard-layout>
    <x-slot:pageTitle>Roles y Permisos</x-slot:pageTitle>
    <x-slot:pageSubtitle>Administra los roles y sus permisos en el sistema</x-slot:pageSubtitle>
    <x-slot:headerActions>
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalCrearRol">
            <i class="fa-solid fa-plus mr-1"></i>
            Nuevo Rol
        </button>
    </x-slot:headerActions>

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

        <!-- Roles Cards -->
        <div class="row">
            @foreach ($roles as $role)
                <div class="col-lg-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center {{ $role->name === 'Administrador' ? 'bg-danger' : 'bg-info' }}">
                            <h6 class="m-0 font-weight-bold text-white">
                                <i class="fa-solid fa-shield-halved mr-2"></i>{{ $role->name }}
                            </h6>
                            <div>
                                <span class="badge badge-light mr-2">
                                    {{ $role->users->count() }} {{ $role->users->count() === 1 ? 'usuario' : 'usuarios' }}
                                </span>
                                @if ($role->name !== 'Administrador')
                                    <button class="btn btn-sm btn-warning btn-editar-rol"
                                        data-id="{{ $role->id }}"
                                        data-name="{{ $role->name }}"
                                        data-permissions="{{ $role->permissions->pluck('name')->toJson() }}"
                                        data-toggle="modal"
                                        data-target="#modalEditarRol"
                                        title="Editar">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger btn-eliminar-rol"
                                        data-id="{{ $role->id }}"
                                        data-name="{{ $role->name }}"
                                        data-users="{{ $role->users->count() }}"
                                        data-toggle="modal"
                                        data-target="#modalEliminarRol"
                                        title="Eliminar">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="small text-muted mb-3">
                                @if ($role->name === 'Administrador')
                                    <i class="fa-solid fa-circle-info mr-1"></i>
                                    Este rol tiene acceso completo al sistema y no puede ser modificado.
                                @else
                                    <i class="fa-solid fa-circle-info mr-1"></i>
                                    Permisos asignados a este rol:
                                @endif
                            </p>

                            @foreach ($permisosAgrupados as $modulo => $permisos)
                                @php
                                    $permisosDelRol = $role->permissions->pluck('name')->toArray();
                                    $tieneAlguno = false;
                                    foreach ($permisos as $p) {
                                        if (in_array($p->name, $permisosDelRol)) {
                                            $tieneAlguno = true;
                                            break;
                                        }
                                    }
                                @endphp
                                @if ($tieneAlguno || $role->name === 'Administrador')
                                    <div class="mb-2">
                                        <strong class="small text-uppercase" style="color: var(--alu-primary);">{{ $modulo }}</strong>
                                        <div class="d-flex flex-wrap mt-1">
                                            @foreach ($permisos as $permiso)
                                                @php
                                                    $tiene = in_array($permiso->name, $permisosDelRol);
                                                    $parts = explode('.', $permiso->name);
                                                    $accion = end($parts);
                                                    $etiquetas = [
                                                        'index' => 'Ver',
                                                        'store' => 'Crear',
                                                        'edit' => 'Editar',
                                                        'update' => 'Actualizar',
                                                        'destroy' => 'Eliminar',
                                                        'updateEnable' => 'Habilitar',
                                                        'pdf' => 'Ver PDF',
                                                        'descargar' => 'Descargar',
                                                    ];
                                                    $etiqueta = $etiquetas[$accion] ?? ucfirst($accion);
                                                @endphp
                                                <span class="badge mr-1 mb-1 {{ $tiene ? 'badge-success' : 'badge-secondary' }}" style="font-size: 0.75rem;">
                                                    <i class="fa-solid {{ $tiene ? 'fa-check' : 'fa-xmark' }} mr-1"></i>{{ $etiqueta }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal Crear Rol -->
    <div class="modal fade" id="modalCrearRol" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h6 class="modal-title font-weight-bold text-white">
                        <i class="fa-solid fa-shield-halved mr-2"></i>Nuevo Rol
                    </h6>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('dashboard.roles.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombre_rol" class="font-weight-bold">Nombre del Rol</label>
                            <input type="text" class="form-control" id="nombre_rol" name="name" required
                                   placeholder="Ej: Supervisor, Vendedor...">
                        </div>
                        <hr>
                        <h6 class="font-weight-bold mb-3">
                            <i class="fa-solid fa-key mr-1"></i> Asignar Permisos
                        </h6>
                        @foreach ($permisosAgrupados as $modulo => $permisos)
                            <div class="card mb-2">
                                <div class="card-header py-2 d-flex justify-content-between align-items-center" style="cursor: pointer;"
                                     data-toggle="collapse" data-target="#crear_modulo_{{ Str::slug($modulo) }}">
                                    <strong class="small">{{ $modulo }}</strong>
                                    <div>
                                        <button type="button" class="btn btn-outline-success btn-sm btn-seleccionar-todos mr-1"
                                                data-target-group="crear_{{ Str::slug($modulo) }}">
                                            Todos
                                        </button>
                                        <i class="fa-solid fa-chevron-down small"></i>
                                    </div>
                                </div>
                                <div class="collapse show" id="crear_modulo_{{ Str::slug($modulo) }}">
                                    <div class="card-body py-2">
                                        <div class="row">
                                            @foreach ($permisos as $permiso)
                                                @php
                                                    $parts = explode('.', $permiso->name);
                                                    $accion = end($parts);
                                                    $etiquetas = [
                                                        'index' => 'Ver',
                                                        'store' => 'Crear',
                                                        'edit' => 'Editar',
                                                        'update' => 'Actualizar',
                                                        'destroy' => 'Eliminar',
                                                        'updateEnable' => 'Habilitar/Deshabilitar',
                                                        'pdf' => 'Ver PDF',
                                                        'descargar' => 'Descargar PDF',
                                                    ];
                                                    $etiqueta = $etiquetas[$accion] ?? ucfirst($accion);
                                                @endphp
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="custom-control custom-checkbox mb-2">
                                                        <input class="custom-control-input permiso-check crear_{{ Str::slug($modulo) }}"
                                                               type="checkbox"
                                                               name="permissions[]"
                                                               value="{{ $permiso->name }}"
                                                               id="crear_{{ $permiso->id }}">
                                                        <label class="custom-control-label" for="crear_{{ $permiso->id }}">
                                                            {{ $etiqueta }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-success" type="submit">
                            <i class="fa-solid fa-floppy-disk mr-1"></i>Guardar Rol
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Rol -->
    <div class="modal fade" id="modalEditarRol" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h6 class="modal-title font-weight-bold text-white">
                        <i class="fa-solid fa-shield-halved mr-2"></i>Editar Rol
                    </h6>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="" id="formEditarRol">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_nombre_rol" class="font-weight-bold">Nombre del Rol</label>
                            <input type="text" class="form-control" id="edit_nombre_rol" name="name" required>
                        </div>
                        <hr>
                        <h6 class="font-weight-bold mb-3">
                            <i class="fa-solid fa-key mr-1"></i> Asignar Permisos
                        </h6>
                        @foreach ($permisosAgrupados as $modulo => $permisos)
                            <div class="card mb-2">
                                <div class="card-header py-2 d-flex justify-content-between align-items-center" style="cursor: pointer;"
                                     data-toggle="collapse" data-target="#editar_modulo_{{ Str::slug($modulo) }}">
                                    <strong class="small">{{ $modulo }}</strong>
                                    <div>
                                        <button type="button" class="btn btn-outline-success btn-sm btn-seleccionar-todos mr-1"
                                                data-target-group="editar_{{ Str::slug($modulo) }}">
                                            Todos
                                        </button>
                                        <i class="fa-solid fa-chevron-down small"></i>
                                    </div>
                                </div>
                                <div class="collapse show" id="editar_modulo_{{ Str::slug($modulo) }}">
                                    <div class="card-body py-2">
                                        <div class="row">
                                            @foreach ($permisos as $permiso)
                                                @php
                                                    $parts = explode('.', $permiso->name);
                                                    $accion = end($parts);
                                                    $etiquetas = [
                                                        'index' => 'Ver',
                                                        'store' => 'Crear',
                                                        'edit' => 'Editar',
                                                        'update' => 'Actualizar',
                                                        'destroy' => 'Eliminar',
                                                        'updateEnable' => 'Habilitar/Deshabilitar',
                                                        'pdf' => 'Ver PDF',
                                                        'descargar' => 'Descargar PDF',
                                                    ];
                                                    $etiqueta = $etiquetas[$accion] ?? ucfirst($accion);
                                                @endphp
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="custom-control custom-checkbox mb-2">
                                                        <input class="custom-control-input permiso-check editar_{{ Str::slug($modulo) }}"
                                                               type="checkbox"
                                                               name="permissions[]"
                                                               value="{{ $permiso->name }}"
                                                               id="editar_{{ $permiso->id }}">
                                                        <label class="custom-control-label" for="editar_{{ $permiso->id }}">
                                                            {{ $etiqueta }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-warning" type="submit">
                            <i class="fa-solid fa-pen-to-square mr-1"></i>Modificar Rol
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Eliminar Rol -->
    <div class="modal fade" id="modalEliminarRol" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title font-weight-bold text-white">Eliminar Rol</h6>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Estas seguro de que deseas eliminar el rol <strong id="nombreRolEliminar"></strong>?</p>
                    <p class="text-muted small">Esta accion no se puede deshacer.</p>
                    <div id="alertaUsuariosRol" class="alert alert-warning d-none">
                        <i class="fa-solid fa-triangle-exclamation mr-1"></i>
                        Este rol tiene usuarios asignados y no puede ser eliminado.
                    </div>
                </div>
                <form action="" method="POST" id="formEliminarRol">
                    @csrf
                    @method('DELETE')
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-danger" type="submit" id="btnConfirmarEliminarRol">
                            <i class="fa-solid fa-trash-can mr-1"></i>Eliminar Rol
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @section('otherScripts')
        <script>
            // Editar rol - cargar datos en el modal
            $(document).on('click', '.btn-editar-rol', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var permissions = $(this).data('permissions');

                $('#edit_nombre_rol').val(name);
                $('#formEditarRol').attr('action', '/dashboard/roles/' + id);

                // Desmarcar todos los checkboxes del modal editar
                $('#modalEditarRol .permiso-check').prop('checked', false);

                // Marcar los permisos del rol
                if (permissions && permissions.length > 0) {
                    permissions.forEach(function(perm) {
                        $('#modalEditarRol .permiso-check[value="' + perm + '"]').prop('checked', true);
                    });
                }
            });

            // Eliminar rol - cargar datos en el modal
            $(document).on('click', '.btn-eliminar-rol', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var users = $(this).data('users');

                $('#nombreRolEliminar').text(name);
                $('#formEliminarRol').attr('action', '/dashboard/roles/' + id);

                if (users > 0) {
                    $('#alertaUsuariosRol').removeClass('d-none');
                    $('#btnConfirmarEliminarRol').prop('disabled', true);
                } else {
                    $('#alertaUsuariosRol').addClass('d-none');
                    $('#btnConfirmarEliminarRol').prop('disabled', false);
                }
            });

            // Seleccionar/Deseleccionar todos los permisos de un módulo
            $(document).on('click', '.btn-seleccionar-todos', function(e) {
                e.stopPropagation();
                var group = $(this).data('target-group');
                var checkboxes = $('.' + group);
                var allChecked = checkboxes.length === checkboxes.filter(':checked').length;
                checkboxes.prop('checked', !allChecked);
            });
        </script>
    @endsection
</x-dashboard-layout>