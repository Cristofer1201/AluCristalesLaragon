<x-dashboard-layout>
    <x-slot:pageTitle>Gestion de Productos</x-slot:pageTitle>
    <x-slot:pageSubtitle>Administra los productos del sistema</x-slot:pageSubtitle>
    <x-slot:headerActions>
        <button type="button" class="btn btn-success btn-sm mr-2" data-toggle="modal" data-target="#modalGuardarProductos">
            <i class="fa-solid fa-plus mr-1"></i>
            Nuevo Producto
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

        <!-- Tabla de Tipos de Producto (Categorias) -->
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header bg-success py-3">
                        <h6 class="m-0 font-weight-bold text-white">
                            <i class="fa-solid fa-layer-group mr-2"></i>Tipos de Producto
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tabla-tipos" class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">Imagen</th>
                                        <th>Tipo de Producto</th>
                                        <th class="text-center">Productos</th>
                                        <th class="text-center">Activos</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tipos as $tipo)
                                        @php
                                            $productosTipo = $productos->where('tipo', $tipo);
                                            $activos = $productosTipo->where('activo', 1)->count();
                                        @endphp
                                        <tr style="cursor: pointer;" class="fila-tipo" data-tipo="{{ $tipo }}">
                                            <td class="text-center align-middle">
                                                @if(isset($imagenesTipo[$tipo]))
                                                    <img src="{{ $imagenesTipo[$tipo] }}" alt="{{ $tipo }}"
                                                         style="width: 45px; height: 45px; object-fit: cover; border-radius: 6px; border: 1px solid #dee2e6;">
                                                @else
                                                    <div style="width: 45px; height: 45px; border-radius: 6px; background: #e9ecef; display: inline-flex; align-items: center; justify-content: center;">
                                                        <i class="fa-solid fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                <span class="font-weight-bold" style="font-size: 1rem;">{{ $tipo }}</span>
                                            </td>
                                            <td class="text-center align-middle">
                                                <span class="badge badge-info px-3 py-1" style="font-size: 0.85rem;">{{ $productosTipo->count() }}</span>
                                            </td>
                                            <td class="text-center align-middle">
                                                <span class="badge badge-success px-3 py-1" style="font-size: 0.85rem;">{{ $activos }}</span>
                                            </td>
                                            <td class="text-center align-middle">
                                                <button class="btn btn-info btn-sm btn-ver-productos" data-tipo="{{ $tipo }}" data-toggle="modal" data-target="#modalProductosTipo" title="Ver productos">
                                                    <i class="fa-solid fa-eye mr-1"></i> Ver
                                                </button>
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

    <!-- Modal Productos por Tipo -->
    <div class="modal fade" id="modalProductosTipo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h6 class="modal-title font-weight-bold text-white">
                        <i class="fa-solid fa-list mr-2"></i>Productos: <span id="tipoSeleccionado"></span>
                    </h6>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nro</th>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Creacion</th>
                                    <th class="text-center">Habilitado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyProductosTipo">
                                {{-- Se llena dinámicamente con JS --}}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Datos de productos en JSON para JS -->
    <script id="productosData" type="application/json">{!! json_encode($productosJson) !!}</script>

    <div>
        <!-- Modal Guardar -->
        <div class="modal fade" id="modalGuardarProductos" tabindex="-1" aria-labelledby="modalLabelGuardarProductos" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h6 class="modal-title font-weight-bold text-white" id="modalLabelGuardarProductos">Registro de productos</h6>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alertaValidacion alert alert-danger alert-dismissible fade show d-none" role="alert">
                        <span>Todos los campos son obligatorios.</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="needs-validation" novalidate id="formGuardarProducto" method="post"
                        action="{{ route('dashboard.productos.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <label for="nombre" class="form-label">Nombre del producto:</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                    <div class="invalid-feedback">Ingrese un nombre valido</div>
                                </div>
                                <div class="col-md-5">
                                    <label for="tipo" class="form-label">Categoria:</label>
                                    <input type="text" class="form-control" id="tipo" name="tipo" list="listaTipos" placeholder="Ej: Cerramientos">
                                    <datalist id="listaTipos">
                                        @foreach ($tipos as $tipo)
                                            <option value="{{ $tipo }}">
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="descripcion" class="form-label">Descripcion:</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="imagen" class="form-label">Imagen del producto:</label>
                                    <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/png,image/jpeg,image/webp">
                                    <small class="form-text text-muted">PNG, JPG o WEBP. Max 2MB.</small>
                                    <div id="imagen-preview-crear" class="mt-2" style="display:none;">
                                        <img src="" alt="Vista previa" style="max-width: 120px; max-height: 120px; object-fit: contain; border-radius: 4px; border: 1px solid #ddd;">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="activo" id="activo" value="1" checked>
                                        <label class="form-check-label">Activo</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="activo" id="inactivo" value="0">
                                        <label class="form-check-label">Inactivo</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="mx-2">
                                        <button class="btn btn-success" type="submit">
                                            <i class="fa-solid fa-floppy-disk"></i> Guardar Producto
                                        </button>
                                    </div>
                                    <div class="mx-2">
                                        <button class="btn btn-info" type="button" onclick="fnLimpiarProducto();">
                                            <i class="fa-solid fa-broom"></i> Limpiar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="modalEditarProductos" tabindex="-1" aria-labelledby="modalLabelEditarProductos" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h6 class="modal-title font-weight-bold text-white" id="modalLabelEditarProductos">Modificar Producto</h6>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alertaValidacion alert alert-danger alert-dismissible fade show d-none" role="alert">
                        <span>Todos los campos son obligatorios.</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="needs-validation" novalidate id="formEditarProducto" method="post" action="" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <label for="edit_nombre" class="form-label">Nombre del producto:</label>
                                    <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
                                    <div class="invalid-feedback">Ingrese un nombre valido</div>
                                </div>
                                <div class="col-md-5">
                                    <label for="edit_tipo" class="form-label">Categoria:</label>
                                    <input type="text" class="form-control" id="edit_tipo" name="tipo" list="listaTiposEdit" placeholder="Ej: Cerramientos">
                                    <datalist id="listaTiposEdit">
                                        @foreach ($tipos as $tipo)
                                            <option value="{{ $tipo }}">
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="edit_descripcion" class="form-label">Descripcion:</label>
                                    <textarea class="form-control" id="edit_descripcion" name="descripcion" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="edit_imagen" class="form-label">Imagen del producto:</label>
                                    <div id="imagen-actual-container" class="mb-2" style="display:none;">
                                        <img id="imagen-actual" src="" alt="Imagen actual"
                                             style="max-width: 120px; max-height: 120px; object-fit: contain; border-radius: 4px; border: 1px solid #ddd;">
                                        <p class="small text-muted mt-1 mb-0">Imagen actual</p>
                                    </div>
                                    <input type="file" class="form-control-file" id="edit_imagen" name="imagen" accept="image/png,image/jpeg,image/webp">
                                    <div id="imagen-preview-editar" class="mt-2" style="display:none;">
                                        <img src="" alt="Nueva imagen" style="max-width: 120px; max-height: 120px; object-fit: contain; border-radius: 4px; border: 1px solid #ddd;">
                                        <p class="small text-muted mt-1 mb-0">Nueva imagen seleccionada</p>
                                    </div>
                                    <small class="form-text text-muted">Dejar vacio para mantener la imagen actual.</small>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="activo" id="edit_activo" value="1">
                                        <label class="form-check-label" for="edit_activo">Activo</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="activo" id="edit_inactivo" value="0">
                                        <label class="form-check-label" for="edit_inactivo">Inactivo</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                            <button class="btn btn-warning" type="submit">
                                <i class="fa-solid fa-pen-to-square mr-1"></i> Modificar Producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Delete -->
        <div class="modal fade" id="modalEliminarProductos" tabindex="-1" aria-labelledby="modalLabelEliminarProductos" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h6 class="modal-title font-weight-bold text-white" id="modalLabelEliminarProductos">Eliminar Producto</h6>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Estas seguro de que deseas eliminar el producto <strong id="nombreProductoEliminar"></strong>?</p>
                        <p class="text-muted small">Esta accion no se puede deshacer.</p>
                    </div>
                    <form action="" method="post" id="formEliminarProducto">
                        @csrf
                        @method('DELETE')
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                            <button class="btn btn-danger" type="submit">
                                <i class="fa-solid fa-trash-can mr-1"></i> Eliminar Producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Previsualizar Imagen -->
    <div class="modal fade" id="modalPrevisualizarImagen" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background: transparent; border: none;">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title text-white font-weight-bold" id="previewImagenTitulo"></h6>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center p-2">
                    <img id="previewImagenSrc" src="" alt="" style="max-width: 100%; max-height: 70vh; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.5);">
                </div>
            </div>
        </div>
    </div>

    @section('otherScripts')
        <script src="{{ asset('js/dashboard/rulesMantenimientoProductos.js') }}"></script>
        <script>
            var productosData = JSON.parse(document.getElementById('productosData').textContent);

            function previsualizarImagen(src, nombre) {
                document.getElementById('previewImagenSrc').src = src;
                document.getElementById('previewImagenTitulo').textContent = nombre;
                // Cerrar modal de productos primero, luego abrir preview
                $('#modalProductosTipo').modal('hide');
                setTimeout(function() {
                    $('#modalPrevisualizarImagen').modal('show');
                }, 400);
            }

            $(document).ready(function() {
                // DataTable para tabla de tipos
                $('#tabla-tipos').DataTable({
                    "language": {
                        "lengthMenu": "Mostrar _MENU_ registros por pagina",
                        "zeroRecords": "No se encontraron tipos",
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
                    "order": [[1, 'asc']],
                    "columnDefs": [
                        { "orderable": false, "targets": [0, 4] }
                    ],
                    "paging": false,
                    "info": false
                });

                // Clic en fila de tipo -> abrir modal
                $(document).on('click', '.fila-tipo td:not(:last-child)', function() {
                    var tipo = $(this).closest('tr').data('tipo');
                    abrirModalProductos(tipo);
                });

                // Boton ver productos
                $(document).on('click', '.btn-ver-productos', function(e) {
                    e.stopPropagation();
                    var tipo = $(this).data('tipo');
                    abrirModalProductos(tipo);
                });

                function abrirModalProductos(tipo) {
                    $('#tipoSeleccionado').text(tipo);
                    var tbody = $('#tbodyProductosTipo');
                    tbody.empty();

                    var productosFiltrados = productosData.filter(function(p) {
                        return p.tipo === tipo;
                    });

                    if (productosFiltrados.length === 0) {
                        tbody.append('<tr><td colspan="7" class="text-center text-muted py-4">No hay productos en esta categoria</td></tr>');
                        return;
                    }

                    productosFiltrados.forEach(function(p) {
                        var imgHtml = p.imagen
                            ? '<img src="' + p.imagen + '" alt="' + p.nombre + '" style="width:45px;height:45px;object-fit:cover;border-radius:4px;cursor:pointer;" onclick="previsualizarImagen(\'' + p.imagen.replace(/'/g, "\\'") + '\', \'' + p.nombre.replace(/'/g, "\\'") + '\')">'
                            : '<span class="text-muted"><i class="fa-solid fa-image"></i></span>';

                        var estadoHtml = p.activo
                            ? '<i class="fa-solid fa-check text-success"></i>'
                            : '<i class="fa-solid fa-xmark text-secondary"></i>';

                        var accionesHtml = '';
                        @can('dashboard.productos.edit')
                        accionesHtml += '<button class="btn btn-warning btn-sm mx-1 btn-editar-producto" ' +
                            'data-id="' + p.id + '" ' +
                            'data-nombre="' + (p.nombre || '').replace(/"/g, '&quot;') + '" ' +
                            'data-descripcion="' + (p.descripcion || '').replace(/"/g, '&quot;') + '" ' +
                            'data-tipo="' + (p.tipo || '').replace(/"/g, '&quot;') + '" ' +
                            'data-activo="' + p.activo + '" ' +
                            'data-imagen="' + (p.imagen_storage || '') + '" ' +
                            'title="Editar">' +
                            '<i class="fa-solid fa-pen-to-square"></i></button>';
                        @endcan
                        @can('dashboard.productos.destroy')
                        accionesHtml += '<button class="btn btn-danger btn-sm mx-1 btn-eliminar-producto" ' +
                            'data-id="' + p.id + '" ' +
                            'data-nombre="' + (p.nombre || '').replace(/"/g, '&quot;') + '" ' +
                            'title="Eliminar">' +
                            '<i class="fa-solid fa-trash-can"></i></button>';
                        @endcan

                        tbody.append(
                            '<tr>' +
                                '<td>' + p.orden + '</td>' +
                                '<td class="text-center">' + imgHtml + '</td>' +
                                '<td>' + p.nombre + '</td>' +
                                '<td>' + (p.descripcion || '-') + '</td>' +
                                '<td>' + p.created_at + '</td>' +
                                '<td class="text-center">' + estadoHtml + '</td>' +
                                '<td class="text-center"><div class="d-flex justify-content-center">' + accionesHtml + '</div></td>' +
                            '</tr>'
                        );
                    });

                    $('#modalProductosTipo').modal('show');
                }

                // Editar producto - cerrar modal de productos, abrir modal editar
                $(document).on('click', '.btn-editar-producto', function(e) {
                    e.stopPropagation();
                    var id = $(this).data('id');
                    var nombre = $(this).data('nombre');
                    var descripcion = $(this).data('descripcion');
                    var tipo = $(this).data('tipo');
                    var activo = $(this).data('activo');
                    var imagen = $(this).data('imagen');

                    $('#edit_nombre').val(nombre);
                    $('#edit_descripcion').val(descripcion);
                    $('#edit_tipo').val(tipo || '');

                    if (activo == 1) {
                        $('#edit_activo').prop('checked', true);
                    } else {
                        $('#edit_inactivo').prop('checked', true);
                    }

                    if (imagen) {
                        $('#imagen-actual').attr('src', imagen);
                        $('#imagen-actual-container').show();
                    } else {
                        $('#imagen-actual-container').hide();
                    }

                    // Resetear preview de nueva imagen
                    $('#edit_imagen').val('');
                    $('#imagen-preview-editar').hide();

                    var actionUrl = "{{ route('dashboard.productos.update', ':id') }}".replace(':id', id);
                    $('#formEditarProducto').attr('action', actionUrl);

                    $('#modalProductosTipo').modal('hide');
                    setTimeout(function() {
                        $('#modalEditarProductos').modal('show');
                    }, 400);
                });

                // Eliminar producto - cerrar modal de productos, abrir modal eliminar
                $(document).on('click', '.btn-eliminar-producto', function(e) {
                    e.stopPropagation();
                    var id = $(this).data('id');
                    var nombre = $(this).data('nombre');

                    $('#nombreProductoEliminar').text(nombre);

                    var actionUrl = "{{ route('dashboard.productos.destroy', ':id') }}".replace(':id', id);
                    $('#formEliminarProducto').attr('action', actionUrl);

                    $('#modalProductosTipo').modal('hide');
                    setTimeout(function() {
                        $('#modalEliminarProductos').modal('show');
                    }, 400);
                });
            });
        </script>
    @endsection
</x-dashboard-layout>
