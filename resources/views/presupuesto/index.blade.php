<x-dashboard-layout>
    <x-slot:pageTitle>Presupuesto</x-slot:pageTitle>
    <x-slot:pageSubtitle>Genera cotizaciones para tus clientes</x-slot:pageSubtitle>
    <x-slot:headerActions>
        <button type="button" class="btn btn-success btn-sm" id="btnNuevoPresupuesto">
            <i class="fa-solid fa-file-circle-plus mr-1"></i>
            Nuevo Presupuesto
        </button>
        <button type="button" class="btn btn-info btn-sm" id="btnExportarPDF">
            <i class="fa-solid fa-file-pdf mr-1"></i>
            Exportar PDF
        </button>
    </x-slot:headerActions>

    <div class="container-fluid py-3">

        <div class="row">
            <!-- Formulario de Producto -->
            <div class="col-lg-12 mb-3" id="panelFormulario">
                <div class="card h-100">
                    <div class="card-header bg-danger">
                        <ul class="nav nav-tabs card-header-tabs" id="presupuestoTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active text-white" id="cliente-tab" data-toggle="tab" href="#cliente" role="tab" aria-controls="cliente" aria-selected="true">
                                    <i class="fa-solid fa-user mr-1"></i> Cliente
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white-50" id="detalles-tab" data-toggle="tab" href="#detalles" role="tab" aria-controls="detalles" aria-selected="false">
                                    <i class="fa-solid fa-clipboard-list mr-1"></i> Detalles
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white-50" id="especificaciones-tab" data-toggle="tab" href="#especificaciones" role="tab" aria-controls="especificaciones" aria-selected="false">
                                    <i class="fa-solid fa-sliders mr-1"></i> Especificaciones
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="presupuestoTabsContent">
                            <!-- Tab Cliente -->
                            <div class="tab-pane fade show active" id="cliente" role="tabpanel" aria-labelledby="cliente-tab">
                                <div class="row">
                                    <!-- Buscar Cliente -->
                                    <div class="col-12 mb-2 position-relative">
                                        <label class="form-label small">Buscar Cliente</label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" id="clienteSearch" placeholder="Escriba el nombre del cliente..." autocomplete="off">
                                            <button class="btn btn-outline-primary btn-sm" type="button" id="btnNuevoCliente" title="Nuevo Cliente">
                                                <i class="fa-solid fa-plus"></i> Nuevo
                                            </button>
                                        </div>
                                        <div id="clienteSearchResults" class="list-group mt-1 position-absolute w-100" style="z-index: 1000; display: none;"></div>
                                    </div>

                                    <input type="hidden" id="clienteId" name="cliente_id" value="">

                                    <div class="col-md-4 mb-2">
                                        <label for="clienteNombre" class="form-label small">Nombre</label>
                                        <input type="text" class="form-control form-control-sm" id="clienteNombre" name="cliente_nombre" placeholder="Nombre completo">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="clienteDireccion" class="form-label small">Direccion</label>
                                        <input type="text" class="form-control form-control-sm" id="clienteDireccion" name="cliente_direccion" placeholder="Direccion">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="clienteTelefono" class="form-label small">Telefono</label>
                                        <input type="text" class="form-control form-control-sm" id="clienteTelefono" name="cliente_telefono" placeholder="Telefono">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="clienteEmail" class="form-label small">Email</label>
                                        <input type="email" class="form-control form-control-sm" id="clienteEmail" name="cliente_email" placeholder="correo@ejemplo.com">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="clienteFax" class="form-label small">Fax</label>
                                        <input type="text" class="form-control form-control-sm" id="clienteFax" name="cliente_fax" placeholder="Fax">
                                    </div>
                                    <div class="col-md-4 mb-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-primary btn-sm btn-block" id="btnGuardarCliente">
                                            <i class="fa-solid fa-save mr-1"></i> Guardar Cliente
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Tab Detalles -->
                            <div class="tab-pane fade" id="detalles" role="tabpanel" aria-labelledby="detalles-tab">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="tipo" class="form-label small">Tipo de Producto</label>
                                        <select class="form-control form-control-sm custom-select" id="tipo" name="tipo">
                                            <option value="">Seleccionar...</option>
                                            @foreach($tipos as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="opcion" class="form-label small">Opcion</label>
                                        <select class="form-control form-control-sm custom-select" id="opcion" name="opcion" disabled>
                                            <option value="">Selecciona tipo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="color" class="form-label small">Color</label>
                                        <select class="form-control form-control-sm custom-select" id="color" name="color" disabled>
                                            <option value="">Selecciona tipo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="tipoDetalle" class="form-label small">Tipo de Detalle</label>
                                        <select class="form-control form-control-sm custom-select" id="tipoDetalle" name="tipoDetalle" disabled>
                                            <option value="">Selecciona tipo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="detalle" class="form-label small">Detalle</label>
                                        <select class="form-control form-control-sm custom-select" id="detalle" name="detalle" disabled>
                                            <option value="">Selecciona tipo detalle</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="ancho" class="form-label small">Ancho</label>
                                        <input type="number" class="form-control form-control-sm" id="ancho" name="ancho" placeholder="0.00" step="0.01" min="0">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="alto" class="form-label small">Altura</label>
                                        <input type="number" class="form-control form-control-sm" id="alto" name="alto" placeholder="0.00" step="0.01" min="0">
                                    </div>
                                    <!-- Resumen de selección -->
                                    <div class="col-12 mt-1">
                                        <div class="p-2 rounded" id="resumenDetalles" style="background: var(--alu-gray-50); border: 1px dashed var(--alu-gray-300); font-size: 0.8rem;">
                                            <div class="d-flex align-items-center mb-1">
                                                <i class="fa-solid fa-clipboard-check mr-2 text-muted"></i>
                                                <strong class="small text-muted">Resumen de selección</strong>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <span class="text-muted">Tipo:</span> <span id="resTipo" class="font-weight-bold">-</span><br>
                                                    <span class="text-muted">Opción:</span> <span id="resOpcion" class="font-weight-bold">-</span><br>
                                                    <span class="text-muted">Color:</span> <span id="resColor" class="font-weight-bold">-</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <span class="text-muted">Detalle:</span> <span id="resDetalle" class="font-weight-bold">-</span><br>
                                                    <span class="text-muted">Medidas:</span> <span id="resMedidas" class="font-weight-bold">-</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab Especificaciones -->
                            <div class="tab-pane fade" id="especificaciones" role="tabpanel" aria-labelledby="especificaciones-tab">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="premarco" class="form-label small">Premarco</label>
                                        <select class="form-control form-control-sm custom-select" id="premarco" name="premarco" disabled>
                                            <option value="">Selecciona tipo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="linea" class="form-label small">Linea</label>
                                        <select class="form-control form-control-sm custom-select" id="linea" name="linea" disabled>
                                            <option value="">Selecciona tipo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="tapajuntas" class="form-label small">Tapajuntas</label>
                                        <select class="form-control form-control-sm custom-select" id="tapajuntas" name="tapajuntas" disabled>
                                            <option value="">Selecciona tipo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="angulo" class="form-label small">Angulo</label>
                                        <select class="form-control form-control-sm custom-select" id="angulo" name="angulo" disabled>
                                            <option value="">Selecciona tipo</option>
                                        </select>
                                    </div>
                                </div>
                                <hr class="my-2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel de Precio -->
            <div class="col-lg-4 mb-3" id="panelPrecio" style="display: none;">
                <div class="card h-100">
                    <div class="card-header bg-success">
                        <h6 class="m-0 font-weight-bold text-white">
                            <i class="fa-solid fa-calculator mr-2"></i>
                            Calculo de Precio
                        </h6>
                    </div>
                    <div class="card-body">
                        <!-- Descripcion del producto seleccionado -->
                        <div class="mb-2 p-2 rounded" style="background: var(--alu-gray-50); border: 1px dashed var(--alu-gray-300);">
                            <small class="text-muted d-block mb-1">Producto seleccionado:</small>
                            <strong id="descripcionProducto" class="text-dark" style="font-size: 0.85rem;">Ninguno</strong>
                        </div>

                        <div class="mb-2">
                            <label for="precioUnitario" class="form-label small">Precio Unitario</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="precioUnitario" name="precioUnitario" placeholder="0.00" min="0" step="0.01">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-2">
                                <label for="cantidad" class="form-label small">Cantidad</label>
                                <input type="number" class="form-control form-control-sm" id="cantidad" name="cantidad" placeholder="1" min="1" value="1">
                            </div>
                            <div class="col-6 mb-2">
                                <label for="descuento" class="form-label small">Descuento</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" class="form-control" id="descuento" name="descuento" placeholder="0" min="0" max="100" value="0">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>

                        <hr class="my-2">

                        <!-- Resumen de Calculo -->
                        <div class="calculo-resumen">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted small">Subtotal:</span>
                                <span class="font-weight-bold small" id="resumenSubtotal">$0.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted small">Descuento:</span>
                                <span class="font-weight-bold text-danger small" id="resumenDescuento">-$0.00</span>
                            </div>
                            <hr class="my-1">
                            <div class="d-flex justify-content-between">
                                <span class="h6 mb-0">Total:</span>
                                <span class="h5 mb-0 font-weight-bold" style="color: var(--alu-primary);" id="resumenTotal">$0.00</span>
                            </div>
                        </div>

                        <button type="button" class="btn btn-danger btn-sm btn-block mt-3" id="btnAgregarItem">
                            <i class="fa-solid fa-plus mr-1"></i>
                            Agregar al Presupuesto
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Items -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info">
                        <h6 class="m-0 font-weight-bold text-white">
                            <i class="fa-solid fa-list mr-2"></i>
                            Items del Presupuesto
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="tablaItems">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Descripcion</th>
                                        <th>Cant.</th>
                                        <th>P. Unit.</th>
                                        <th>Desc.</th>
                                        <th>Total</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="itemsBody">
                                    <tr id="emptyRow">
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fa-solid fa-inbox fa-2x mb-2 d-block"></i>
                                            No hay items agregados
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="table-light">
                                        <td colspan="5" class="text-right font-weight-bold">Total Presupuesto:</td>
                                        <td class="font-weight-bold" style="color: var(--alu-primary); font-size: 1.25rem;" id="totalPresupuesto">$0.00</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal Vista Previa del Presupuesto -->
    <div class="modal fade" id="modalVistaPrevia" tabindex="-1" aria-labelledby="modalVistaPreviaLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="border: none; border-radius: 0;">
                <!-- Header del Presupuesto -->
                <div class="presupuesto-header" style="background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); padding: 0;">
                    <div class="row no-gutters">
                        <!-- Logo y Nombre -->
                        <div class="col-md-4" style="background: #dc2626; padding: 1.5rem;">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('img/Logo Alucristales blanco.png') }}" alt="Logo" style="width: 60px; height: auto;" class="mr-3">
                                <div class="text-white">
                                    <h4 class="mb-0 font-weight-bold">ALUCRISTALES</h4>
                                    <span style="font-size: 0.9rem;">PALERMO</span>
                                </div>
                            </div>
                        </div>
                        <!-- Datos de la Empresa -->
                        <div class="col-md-8 text-white text-right" style="padding: 1rem 1.5rem; background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);">
                            <h5 class="mb-1 font-weight-bold" id="previewEmpresaNombre">ALU CRISTALES PALERMO</h5>
                            <p class="mb-0 small" id="previewEmpresaCuit">Cuit: 27-96157559-7 - Responsable inscripto</p>
                            <p class="mb-0 small" id="previewEmpresaDireccion">Oficinas: Araoz 2403 / Guemes 4888 / Palermo (CABA)</p>
                            <p class="mb-0 small">
                                <span id="previewEmpresaTelefonos">Telefonos: 1135649430 - 1163219790</span>
                            </p>
                            <p class="mb-0 small" id="previewEmpresaEmail">cristalespalermo2585@hotmail.com</p>
                        </div>
                    </div>
                </div>

                <!-- Cuerpo del Modal -->
                <div class="modal-body p-0">
                    <!-- Fila de Info del Presupuesto y Cliente -->
                    <div class="row no-gutters" style="border-bottom: 3px solid #dc2626;">
                        <!-- Numero y Fecha -->
                        <div class="col-md-3" style="background: #fef2f2; border-right: 2px solid #dc2626;">
                            <div class="p-3">
                                <div class="mb-3" style="background: #dc2626; color: white; padding: 0.5rem 1rem; margin: -1rem -1rem 1rem -1rem;">
                                    <strong>PRESUPUESTO N°</strong>
                                    <span class="float-right font-weight-bold" id="previewNumero">00001</span>
                                </div>
                                <div class="mb-2">
                                    <strong>FECHA:</strong>
                                    <span class="float-right" id="previewFecha">{{ now()->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <!-- Datos del Cliente -->
                        <div class="col-md-6" style="border-right: 1px solid #e5e7eb;">
                            <div class="p-3">
                                <div class="row">
                                    <div class="col-4 text-right pr-2"><strong>Nombre:</strong></div>
                                    <div class="col-8" id="previewClienteNombre">-</div>
                                </div>
                                <div class="row">
                                    <div class="col-4 text-right pr-2"><strong>Direccion:</strong></div>
                                    <div class="col-8" id="previewClienteDireccion">-</div>
                                </div>
                                <div class="row">
                                    <div class="col-4 text-right pr-2"><strong>Telefono:</strong></div>
                                    <div class="col-8" id="previewClienteTelefono">-</div>
                                </div>
                                <div class="row">
                                    <div class="col-4 text-right pr-2"><strong>Email:</strong></div>
                                    <div class="col-8" id="previewClienteEmail">-</div>
                                </div>
                            </div>
                        </div>
                        <!-- Fax -->
                        <div class="col-md-3">
                            <div class="p-3">
                                <div class="row">
                                    <div class="col-5 text-right"><strong>Fax:</strong></div>
                                    <div class="col-7" id="previewClienteFax">-</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Items -->
                    <div class="p-3">
                        <div class="table-responsive" style="min-height: 200px; max-height: 300px; overflow-y: auto;">
                            <table class="table table-bordered table-sm mb-0" id="tablaPreviewItems">
                                <thead style="background: #f3f4f6;">
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 45%;">Descripcion</th>
                                        <th style="width: 10%;">Cant.</th>
                                        <th style="width: 15%;">P. Unit.</th>
                                        <th style="width: 10%;">Desc.</th>
                                        <th style="width: 15%;">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="previewItemsBody">
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            No hay items agregados
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Observacion -->
                    <div class="px-3 pb-3">
                        <div class="p-2" style="border: 1px solid #e5e7eb; border-radius: 4px;">
                            <strong class="d-block mb-1" style="font-size: 0.8rem;">OBSERVACION:</strong>
                            <textarea class="form-control form-control-sm" id="previewObservacion" rows="2" placeholder="Escriba observaciones adicionales..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Footer con Totales -->
                <div class="modal-footer p-0" style="border-top: 3px solid #dc2626;">
                    <div class="row no-gutters w-100">
                        <!-- Totales -->
                        <div class="col-md-6 p-3" style="background: #f9fafb;">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-2">
                                        <strong>Subtotal:</strong>
                                        <span class="float-right" id="previewSubtotal">$ 0</span>
                                    </div>
                                    <div class="mb-2">
                                        <strong>Total:</strong>
                                        <span class="float-right font-weight-bold" style="font-size: 1.2rem;" id="previewTotal">$ 0</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-2">
                                        <strong>I V A 21%:</strong>
                                        <span class="float-right" id="previewIVA">$ 0</span>
                                    </div>
                                    <div class="form-group mb-0">
                                        <select class="form-control form-control-sm" id="previewAplicaIVA">
                                            <option value="1">Implementar IVA</option>
                                            <option value="0">Sin IVA</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Botones -->
                        <div class="col-md-6 p-3 d-flex align-items-center justify-content-end" style="background: #f3f4f6;">
                            <button type="button" class="btn btn-danger mr-2" id="btnDescargarPDF">
                                <i class="fa-solid fa-file-pdf mr-1"></i>
                                DESCARGAR PDF
                            </button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCancelarPreview">
                                <i class="fa-solid fa-times mr-1"></i>
                                CANCELAR
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmacion Nuevo Presupuesto -->
    <div class="modal fade" id="modalConfirmarNuevo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-warning py-2">
                    <h6 class="modal-title font-weight-bold text-white">
                        <i class="fa-solid fa-triangle-exclamation mr-1"></i> Confirmar
                    </h6>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="fa-solid fa-file-circle-exclamation fa-3x text-warning mb-3"></i>
                    <p class="mb-0">Se perderan los items del presupuesto actual.<br><strong>¿Desea continuar?</strong></p>
                </div>
                <div class="modal-footer justify-content-center py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                        <i class="fa-solid fa-times mr-1"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-warning btn-sm" id="btnConfirmarNuevo">
                        <i class="fa-solid fa-check mr-1"></i> Si, continuar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Item -->
    <div class="modal fade" id="modalEditarItem" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning py-2">
                    <h6 class="modal-title font-weight-bold text-white">
                        <i class="fa-solid fa-pen-to-square mr-1"></i> Editar Item
                    </h6>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editItemId">
                    <div class="mb-3 p-2 rounded" style="background: var(--alu-gray-50); border: 1px dashed var(--alu-gray-300);">
                        <small class="text-muted d-block mb-1">Producto:</small>
                        <strong id="editItemDescripcion" class="text-dark"></strong>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label class="form-label small">Precio Unitario</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="editItemPrecio" placeholder="0.00" min="0" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label small">Cantidad</label>
                            <input type="number" class="form-control form-control-sm" id="editItemCantidad" placeholder="1" min="1" value="1">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label small">Descuento</label>
                            <div class="input-group input-group-sm">
                                <input type="number" class="form-control" id="editItemDescuento" placeholder="0" min="0" max="100" value="0">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label small">Ancho</label>
                            <input type="number" class="form-control form-control-sm" id="editItemAncho" placeholder="0.00" step="0.01" min="0">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label small">Altura</label>
                            <input type="number" class="form-control form-control-sm" id="editItemAlto" placeholder="0.00" step="0.01" min="0">
                        </div>
                    </div>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Total estimado:</span>
                        <span class="h5 mb-0 font-weight-bold" style="color: var(--alu-primary);" id="editItemTotal">$0.00</span>
                    </div>
                </div>
                <div class="modal-footer justify-content-center py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                        <i class="fa-solid fa-times mr-1"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-warning btn-sm" id="btnGuardarEditItem">
                        <i class="fa-solid fa-check mr-1"></i> Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </div>

    @section('otherLinks')
    <style>
        /* Tabs personalizados */
        #presupuestoTabs .nav-link {
            border: none;
            border-radius: 0;
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            transition: all 0.2s ease;
        }

        #presupuestoTabs .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white !important;
        }

        #presupuestoTabs .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white !important;
        }

        /* Fix para dropdowns cortados */
        .card {
            overflow: visible !important;
        }

        .card-body {
            overflow: visible !important;
        }

        .tab-content {
            overflow: visible !important;
        }

        .tab-pane {
            overflow: visible !important;
        }

        /* Fix para texto cortado en selects - Override SB Admin 2 */
        .container-fluid .custom-select,
        #detalles .custom-select,
        .tab-pane .custom-select {
            font-size: 0.8rem !important;
            background: #fff url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='4' height='5' viewBox='0 0 4 5'%3e%3cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e") right 0.5rem center/8px 10px no-repeat !important;
            padding: 0.5rem 1.5rem 0.5rem 0.5rem !important;
            height: auto !important;
        }


        /* Card body compacto */
        #panelFormulario .card-body,
        #panelPrecio .card-body {
            padding: 0.75rem;
        }

        /* Labels compactas */
        #panelFormulario .form-label,
        #panelPrecio .form-label {
            margin-bottom: 0.15rem;
        }

        /* Resumen de calculo */
        .calculo-resumen {
            background: var(--alu-gray-50);
            border-radius: 0.5rem;
            padding: 0.75rem;
        }

        /* Input group text */
        .input-group-text {
            background: var(--alu-gray-100);
            border-color: #e5e7eb;
            color: var(--alu-gray-600);
        }

        /* Tabla items */
        #tablaItems tbody tr:hover {
            background: var(--alu-primary-light);
        }

        /* Dark mode adjustments */
        body.dark-mode .container-fluid .custom-select,
        body.dark-mode #detalles .custom-select,
        body.dark-mode #especificaciones .custom-select,
        body.dark-mode .tab-pane .custom-select {
            background: #374151 url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='4' height='5' viewBox='0 0 4 5'%3e%3cpath fill='%23ffffff' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e") right 0.5rem center/8px 10px no-repeat !important;
            border-color: #4b5563 !important;
            color: #fff !important;
        }

        body.dark-mode .calculo-resumen {
            background: var(--alu-bg-secondary);
        }

        body.dark-mode .input-group-text {
            background: var(--alu-bg-secondary);
            border-color: var(--alu-border);
            color: var(--alu-text-secondary);
        }

        /* Seccion Cliente */
        #clienteSearchResults {
            max-height: 200px;
            overflow-y: auto;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 0.25rem;
        }

        #clienteSearchResults .list-group-item {
            border-left: none;
            border-right: none;
            font-size: 0.85rem;
        }

        #clienteSearchResults .list-group-item:first-child {
            border-top: none;
        }

        #clienteSearchResults .list-group-item:hover {
            background-color: var(--alu-primary-light);
        }

        .cliente-card .form-control-sm {
            font-size: 0.8rem;
        }

        .cliente-card .form-label {
            font-weight: 500;
        }
    </style>
    @endsection

    @section('otherScripts')
    <script>
        // Opciones dinámicas por tipo de producto
        const opcionesPorTipo = @json($opcionesPorTipo);

        // Colores dinámicos por tipo de producto
        const coloresPorTipo = @json($coloresPorTipo);

        // Tipos de detalle dinámicos por tipo de producto
        const tiposDetallePorTipo = @json($tiposDetallePorTipo);

        // Detalles dinámicos por tipo de detalle
        const detallesPorTipoDetalle = @json($detallesPorTipoDetalle);

        // Especificaciones dinámicas por tipo de producto
        const premarcoPorTipo = @json($premarcoPorTipo);
        const lineaPorTipo = @json($lineaPorTipo);
        const tapajuntasPorTipo = @json($tapajuntasPorTipo);
        const anguloPorTipo = @json($anguloPorTipo);

        // Variables globales
        let items = [];
        let itemCounter = 0;
        window.presupuestoEditarId = null; // null = modo creacion, number = modo edicion

        // Elementos del DOM
        const precioInput = document.getElementById('precioUnitario');
        const cantidadInput = document.getElementById('cantidad');
        const descuentoInput = document.getElementById('descuento');
        const descripcionProducto = document.getElementById('descripcionProducto');

        // Elementos de resumen
        const resumenSubtotal = document.getElementById('resumenSubtotal');
        const resumenDescuento = document.getElementById('resumenDescuento');
        const resumenTotal = document.getElementById('resumenTotal');
        const totalPresupuesto = document.getElementById('totalPresupuesto');

        // Funcion para actualizar descripcion del producto seleccionado
        function actualizarDescripcionProducto() {
            const tipo = document.getElementById('tipo');
            const opcion = document.getElementById('opcion');
            const color = document.getElementById('color');

            let descripcion = 'Ninguno';

            if (tipo.value) {
                descripcion = tipo.options[tipo.selectedIndex].text;

                if (opcion.value) {
                    descripcion += ' - ' + opcion.options[opcion.selectedIndex].text;
                }

                if (color.value) {
                    descripcion += ' (' + color.options[color.selectedIndex].text + ')';
                }
            }

            descripcionProducto.textContent = descripcion;
        }

        // Funcion para calcular precio: Precio × Cantidad - Descuento
        function calcularPrecio() {
            const precio = parseFloat(precioInput.value) || 0;
            const cantidad = parseInt(cantidadInput.value) || 1;
            const descuento = parseFloat(descuentoInput.value) || 0;

            const subtotal = precio * cantidad;
            const descuentoMonto = subtotal * (descuento / 100);
            const total = subtotal - descuentoMonto;

            // Actualizar resumen
            resumenSubtotal.textContent = '$' + subtotal.toFixed(2);
            resumenDescuento.textContent = '-$' + descuentoMonto.toFixed(2);
            resumenTotal.textContent = '$' + total.toFixed(2);

            return { subtotal, descuentoMonto, total };
        }

        // Funcion para mostrar alertas profesionales en vez de alert() nativo
        function mostrarAlerta(tipo, mensaje) {
            var iconos = {
                'success': 'fa-circle-check',
                'danger': 'fa-circle-exclamation',
                'warning': 'fa-triangle-exclamation',
                'info': 'fa-circle-info'
            };
            var icono = iconos[tipo] || iconos['info'];
            var alertHtml = '<div class="alert alert-' + tipo + ' alert-dismissible fade show position-fixed shadow" ' +
                'style="top: 20px; right: 20px; z-index: 9999; min-width: 300px; max-width: 450px;" role="alert">' +
                '<i class="fa-solid ' + icono + ' mr-2"></i>' + mensaje +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span></button></div>';
            var alertEl = $(alertHtml).appendTo('body');
            setTimeout(function() { alertEl.alert('close'); }, 4000);
        }

        // Funcion para agregar item
        function agregarItem() {
            const tipo = document.getElementById('tipo');
            const opcion = document.getElementById('opcion');
            const color = document.getElementById('color');
            const tipoDetalle = document.getElementById('tipoDetalle');
            const detalle = document.getElementById('detalle');
            const ancho = parseFloat(document.getElementById('ancho').value) || 0;
            const alto = parseFloat(document.getElementById('alto').value) || 0;
            const precio = parseFloat(precioInput.value) || 0;
            const cantidad = parseInt(cantidadInput.value) || 1;
            const descuento = parseFloat(descuentoInput.value) || 0;

            // Validaciones
            if (!tipo.value) {
                mostrarAlerta('warning', 'Selecciona un tipo de producto');
                return;
            }
            if (precio <= 0) {
                mostrarAlerta('warning', 'Ingresa un precio válido');
                return;
            }

            const calculo = calcularPrecio();

            itemCounter++;
            const item = {
                id: itemCounter,
                tipo: tipo.options[tipo.selectedIndex].text,
                opcion: opcion.value ? opcion.options[opcion.selectedIndex].text : '-',
                color: color.value ? color.options[color.selectedIndex].text : '-',
                tipoDetalle: tipoDetalle.value ? tipoDetalle.options[tipoDetalle.selectedIndex].text : '-',
                detalle: detalle.value ? detalle.options[detalle.selectedIndex].text : '-',
                ancho: ancho,
                alto: alto,
                cantidad: cantidad,
                precioUnitario: precio,
                descuento: descuento,
                total: calculo.total
            };
            items.push(item);

            renderItems();
            limpiarFormulario();
            actualizarTotalPresupuesto();
        }

        // Funcion para renderizar items
        function renderItems() {
            const tbody = document.getElementById('itemsBody');
            const emptyRow = document.getElementById('emptyRow');

            if (items.length === 0) {
                emptyRow.style.display = '';
                return;
            }

            emptyRow.style.display = 'none';

            // Limpiar filas existentes (excepto emptyRow)
            const rows = tbody.querySelectorAll('tr:not(#emptyRow)');
            rows.forEach(row => row.remove());

            items.forEach((item, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>
                        <strong>${item.tipo}</strong>
                        <br><small class="text-muted">${item.color} - ${item.opcion}</small>
                        ${item.detalle !== '-' ? '<br><small class="text-muted">' + item.tipoDetalle + ': ' + item.detalle + '</small>' : ''}
                        ${item.ancho || item.alto ? '<br><small class="text-muted">' + item.ancho + ' x ' + item.alto + ' cm</small>' : ''}
                    </td>
                    <td>${item.cantidad}</td>
                    <td>$${item.precioUnitario.toFixed(2)}</td>
                    <td>${item.descuento}%</td>
                    <td class="font-weight-bold">$${item.total.toFixed(2)}</td>
                    <td>
                        <button class="btn btn-sm btn-warning mr-1" onclick="editarItem(${item.id})" title="Editar">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="eliminarItem(${item.id})" title="Eliminar">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
            });
        }

        // Funcion para eliminar item
        function eliminarItem(id) {
            items = items.filter(item => item.id !== id);
            renderItems();
            actualizarTotalPresupuesto();
        }

        // Funcion para editar item (abre modal)
        function editarItem(id) {
            var itemIndex = items.findIndex(function(i) { return i.id === id; });
            if (itemIndex === -1) return;
            var item = items[itemIndex];

            // Quitar item de la lista (se re-agrega al hacer clic en Agregar)
            items.splice(itemIndex, 1);
            renderItems();
            actualizarTotalPresupuesto();

            // Helper: buscar key por label en un select
            function findKey(selectEl, labelText) {
                for (var i = 0; i < selectEl.options.length; i++) {
                    if (selectEl.options[i].text === labelText) return selectEl.options[i].value;
                }
                return '';
            }

            // Tipo
            var tipoSelect = document.getElementById('tipo');
            tipoSelect.value = findKey(tipoSelect, item.tipo);
            actualizarOpciones();

            // Opcion, Color, TipoDetalle (ya poblados por actualizarOpciones)
            if (item.opcion !== '-') {
                var opcionSelect = document.getElementById('opcion');
                opcionSelect.value = findKey(opcionSelect, item.opcion);
            }
            if (item.color !== '-') {
                var colorSelect = document.getElementById('color');
                colorSelect.value = findKey(colorSelect, item.color);
            }
            if (item.tipoDetalle !== '-') {
                var tdSelect = document.getElementById('tipoDetalle');
                tdSelect.value = findKey(tdSelect, item.tipoDetalle);
                actualizarDetalles();
                if (item.detalle !== '-') {
                    var detalleSelect = document.getElementById('detalle');
                    detalleSelect.value = findKey(detalleSelect, item.detalle);
                }
            }

            // Medidas y precio
            document.getElementById('ancho').value = item.ancho || '';
            document.getElementById('alto').value = item.alto || '';
            precioInput.value = item.precioUnitario;
            cantidadInput.value = item.cantidad;
            descuentoInput.value = item.descuento;

            actualizarDescripcionProducto();
            actualizarResumenDetalles();

            // Hacer scroll al formulario de detalles
            document.getElementById('detalles').scrollIntoView({ behavior: 'smooth', block: 'start' });
            mostrarAlerta('info', 'Item cargado. Modificá los campos y hacé clic en "+ Agregar al Presupuesto".');
        }

        // Calcular total en tiempo real dentro del modal de edicion
        function calcularTotalEditItem() {
            var precio = parseFloat(document.getElementById('editItemPrecio').value) || 0;
            var cantidad = parseInt(document.getElementById('editItemCantidad').value) || 1;
            var descuento = parseFloat(document.getElementById('editItemDescuento').value) || 0;
            var subtotal = precio * cantidad;
            var total = subtotal - (subtotal * descuento / 100);
            document.getElementById('editItemTotal').textContent = '$' + total.toFixed(2);
        }

        // Event listeners para calcular total en tiempo real en el modal
        ['editItemPrecio', 'editItemCantidad', 'editItemDescuento'].forEach(function(inputId) {
            document.getElementById(inputId).addEventListener('input', calcularTotalEditItem);
        });

        // Guardar cambios del item editado
        document.getElementById('btnGuardarEditItem').addEventListener('click', function() {
            var id = parseInt(document.getElementById('editItemId').value);
            var itemIndex = items.findIndex(function(i) { return i.id === id; });
            if (itemIndex === -1) return;

            var precio = parseFloat(document.getElementById('editItemPrecio').value) || 0;
            var cantidad = parseInt(document.getElementById('editItemCantidad').value) || 1;
            var descuento = parseFloat(document.getElementById('editItemDescuento').value) || 0;
            var subtotal = precio * cantidad;
            var total = subtotal - (subtotal * descuento / 100);

            items[itemIndex].precioUnitario = precio;
            items[itemIndex].cantidad = cantidad;
            items[itemIndex].descuento = descuento;
            items[itemIndex].ancho = parseFloat(document.getElementById('editItemAncho').value) || 0;
            items[itemIndex].alto = parseFloat(document.getElementById('editItemAlto').value) || 0;
            items[itemIndex].total = total;

            renderItems();
            actualizarTotalPresupuesto();
            $('#modalEditarItem').modal('hide');
            mostrarAlerta('success', 'Item actualizado correctamente');
        });

        // Funcion para actualizar total del presupuesto
        function actualizarTotalPresupuesto() {
            const total = items.reduce((sum, item) => sum + item.total, 0);
            totalPresupuesto.textContent = '$' + total.toFixed(2);
        }

        // Funcion para limpiar formulario
        function limpiarFormulario() {
            document.getElementById('tipo').value = '';
            document.getElementById('color').value = '';
            document.getElementById('tipoDetalle').value = '';
            document.getElementById('detalle').value = '';
            document.getElementById('ancho').value = '';
            document.getElementById('alto').value = '';
            // Especificaciones
            document.getElementById('premarco').value = '';
            document.getElementById('linea').value = '';
            document.getElementById('tapajuntas').value = '';
            document.getElementById('angulo').value = '';
            // Precios
            precioInput.value = '';
            cantidadInput.value = '1';
            descuentoInput.value = '0';
            // Reiniciar dropdown de opciones
            actualizarOpciones();
            actualizarDescripcionProducto();
            actualizarResumenDetalles();
            calcularPrecio();
        }

        // Limpieza interna sin confirmacion (usada despues de descargar PDF)
        // Limpia solo items y formulario de producto (mantiene cliente)
        function limpiarItemsYFormulario() {
            items = [];
            itemCounter = 0;
            renderItems();
            limpiarFormulario();
            actualizarTotalPresupuesto();
        }

        // Limpia todo incluyendo datos del cliente (para Nuevo Presupuesto)
        function limpiarPresupuestoCompleto() {
            limpiarItemsYFormulario();
            if (typeof limpiarFormularioCliente === 'function') {
                limpiarFormularioCliente();
            }

            // Salir del modo edicion si estaba activo
            if (window.presupuestoEditarId) {
                window.presupuestoEditarId = null;
                var banner = document.querySelector('.alert-warning.alert-dismissible');
                if (banner) banner.remove();
                // Obtener nuevo numero de presupuesto
                fetch('/api/presupuesto/siguiente-numero')
                    .then(function(r) { return r.json(); })
                    .then(function(data) {
                        if (data.numero) numeroPresupuesto = data.numero;
                    });
            }
        }

        // Funcion para nuevo presupuesto (con confirmacion via modal)
        function nuevoPresupuesto() {
            if (items.length > 0) {
                $('#modalConfirmarNuevo').modal('show');
                return;
            }
            limpiarPresupuestoCompleto();
        }

        // Confirmar nuevo presupuesto desde el modal
        document.getElementById('btnConfirmarNuevo').addEventListener('click', function() {
            $('#modalConfirmarNuevo').modal('hide');
            limpiarPresupuestoCompleto();
        });

        // Funcion para actualizar opciones segun tipo seleccionado
        function actualizarOpciones() {
            const tipoSelect = document.getElementById('tipo');
            const opcionSelect = document.getElementById('opcion');
            const colorSelect = document.getElementById('color');
            const tipoDetalleSelect = document.getElementById('tipoDetalle');
            const tipoSeleccionado = tipoSelect.value;

            // Dropdowns de especificaciones
            const premarcoSelect = document.getElementById('premarco');
            const lineaSelect = document.getElementById('linea');
            const tapajuntasSelect = document.getElementById('tapajuntas');
            const anguloSelect = document.getElementById('angulo');

            // Limpiar opciones, colores y tipos de detalle actuales
            opcionSelect.innerHTML = '';
            colorSelect.innerHTML = '';
            tipoDetalleSelect.innerHTML = '';
            premarcoSelect.innerHTML = '';
            lineaSelect.innerHTML = '';
            tapajuntasSelect.innerHTML = '';
            anguloSelect.innerHTML = '';

            if (!tipoSeleccionado) {
                opcionSelect.innerHTML = '<option value="">Selecciona tipo</option>';
                opcionSelect.disabled = true;
                colorSelect.innerHTML = '<option value="">Selecciona tipo</option>';
                colorSelect.disabled = true;
                tipoDetalleSelect.innerHTML = '<option value="">Selecciona tipo</option>';
                tipoDetalleSelect.disabled = true;
                // Reiniciar detalle
                const detalleSelect = document.getElementById('detalle');
                detalleSelect.innerHTML = '<option value="">Selecciona tipo detalle</option>';
                detalleSelect.disabled = true;
                // Reiniciar especificaciones
                premarcoSelect.innerHTML = '<option value="">Selecciona tipo</option>';
                premarcoSelect.disabled = true;
                lineaSelect.innerHTML = '<option value="">Selecciona tipo</option>';
                lineaSelect.disabled = true;
                tapajuntasSelect.innerHTML = '<option value="">Selecciona tipo</option>';
                tapajuntasSelect.disabled = true;
                anguloSelect.innerHTML = '<option value="">Selecciona tipo</option>';
                anguloSelect.disabled = true;
                return;
            }

            // Obtener opciones para el tipo seleccionado
            const opciones = opcionesPorTipo[tipoSeleccionado];

            if (opciones && Object.keys(opciones).length > 0) {
                opcionSelect.innerHTML = '<option value="">Seleccionar...</option>';
                for (const [key, value] of Object.entries(opciones)) {
                    const option = document.createElement('option');
                    option.value = key;
                    option.textContent = value;
                    opcionSelect.appendChild(option);
                }
                opcionSelect.disabled = false;
            } else {
                opcionSelect.innerHTML = '<option value="">No hay opciones disponibles</option>';
                opcionSelect.disabled = true;
            }

            // Obtener colores para el tipo seleccionado (o usar _default)
            const colores = coloresPorTipo[tipoSeleccionado] || coloresPorTipo['_default'];

            if (colores && Object.keys(colores).length > 0) {
                colorSelect.innerHTML = '<option value="">Seleccionar...</option>';
                for (const [key, value] of Object.entries(colores)) {
                    const option = document.createElement('option');
                    option.value = key;
                    option.textContent = value;
                    colorSelect.appendChild(option);
                }
                colorSelect.disabled = false;
            } else {
                colorSelect.innerHTML = '<option value="">No hay colores disponibles</option>';
                colorSelect.disabled = true;
            }

            // Obtener tipos de detalle para el tipo seleccionado (o usar _default)
            const tiposDetalle = tiposDetallePorTipo[tipoSeleccionado] || tiposDetallePorTipo['_default'];

            if (tiposDetalle && Object.keys(tiposDetalle).length > 0) {
                tipoDetalleSelect.innerHTML = '<option value="">Seleccionar...</option>';
                for (const [key, value] of Object.entries(tiposDetalle)) {
                    const option = document.createElement('option');
                    option.value = key;
                    option.textContent = value;
                    tipoDetalleSelect.appendChild(option);
                }
                tipoDetalleSelect.disabled = false;
            } else {
                tipoDetalleSelect.innerHTML = '<option value="">No hay tipos de detalle disponibles</option>';
                tipoDetalleSelect.disabled = true;
            }

            // Reiniciar detalle cuando cambia el tipo
            const detalleSelect = document.getElementById('detalle');
            detalleSelect.innerHTML = '<option value="">Selecciona tipo detalle</option>';
            detalleSelect.disabled = true;

            // === ESPECIFICACIONES ===

            // Premarco
            const premarcos = premarcoPorTipo[tipoSeleccionado] || premarcoPorTipo['_default'];
            if (premarcos && Object.keys(premarcos).length > 0) {
                premarcoSelect.innerHTML = '<option value="">Seleccionar...</option>';
                for (const [key, value] of Object.entries(premarcos)) {
                    const option = document.createElement('option');
                    option.value = key;
                    option.textContent = value;
                    premarcoSelect.appendChild(option);
                }
                premarcoSelect.disabled = false;
            } else {
                premarcoSelect.innerHTML = '<option value="">N/A</option>';
                premarcoSelect.disabled = true;
            }

            // Linea
            const lineas = lineaPorTipo[tipoSeleccionado] || lineaPorTipo['_default'];
            if (lineas && Object.keys(lineas).length > 0) {
                lineaSelect.innerHTML = '<option value="">Seleccionar...</option>';
                for (const [key, value] of Object.entries(lineas)) {
                    const option = document.createElement('option');
                    option.value = key;
                    option.textContent = value;
                    lineaSelect.appendChild(option);
                }
                lineaSelect.disabled = false;
            } else {
                lineaSelect.innerHTML = '<option value="">N/A</option>';
                lineaSelect.disabled = true;
            }

            // Tapajuntas
            const tapajuntas = tapajuntasPorTipo[tipoSeleccionado] || tapajuntasPorTipo['_default'];
            if (tapajuntas && Object.keys(tapajuntas).length > 0) {
                tapajuntasSelect.innerHTML = '<option value="">Seleccionar...</option>';
                for (const [key, value] of Object.entries(tapajuntas)) {
                    const option = document.createElement('option');
                    option.value = key;
                    option.textContent = value;
                    tapajuntasSelect.appendChild(option);
                }
                tapajuntasSelect.disabled = false;
            } else {
                tapajuntasSelect.innerHTML = '<option value="">N/A</option>';
                tapajuntasSelect.disabled = true;
            }

            // Angulo
            const angulos = anguloPorTipo[tipoSeleccionado] || anguloPorTipo['_default'];
            if (angulos && Object.keys(angulos).length > 0) {
                anguloSelect.innerHTML = '<option value="">Seleccionar...</option>';
                for (const [key, value] of Object.entries(angulos)) {
                    const option = document.createElement('option');
                    option.value = key;
                    option.textContent = value;
                    anguloSelect.appendChild(option);
                }
                anguloSelect.disabled = false;
            } else {
                anguloSelect.innerHTML = '<option value="">N/A</option>';
                anguloSelect.disabled = true;
            }
        }

        // Funcion para actualizar detalles segun tipo de detalle seleccionado
        function actualizarDetalles() {
            const tipoDetalleSelect = document.getElementById('tipoDetalle');
            const detalleSelect = document.getElementById('detalle');
            const tipoDetalleSeleccionado = tipoDetalleSelect.value;

            // Limpiar detalles actuales
            detalleSelect.innerHTML = '';

            if (!tipoDetalleSeleccionado) {
                detalleSelect.innerHTML = '<option value="">Selecciona tipo detalle</option>';
                detalleSelect.disabled = true;
                return;
            }

            // Obtener detalles para el tipo de detalle seleccionado (o usar _default)
            const detalles = detallesPorTipoDetalle[tipoDetalleSeleccionado] || detallesPorTipoDetalle['_default'];

            if (detalles && Object.keys(detalles).length > 0) {
                detalleSelect.innerHTML = '<option value="">Seleccionar...</option>';
                for (const [key, value] of Object.entries(detalles)) {
                    const option = document.createElement('option');
                    option.value = key;
                    option.textContent = value;
                    detalleSelect.appendChild(option);
                }
                detalleSelect.disabled = false;
            } else {
                detalleSelect.innerHTML = '<option value="">No hay detalles disponibles</option>';
                detalleSelect.disabled = true;
            }
        }

        // Actualizar resumen de detalles
        function actualizarResumenDetalles() {
            var tipoSel = document.getElementById('tipo');
            var opcionSel = document.getElementById('opcion');
            var colorSel = document.getElementById('color');
            var detalleSel = document.getElementById('detalle');
            var anchoVal = document.getElementById('ancho').value;
            var altoVal = document.getElementById('alto').value;

            document.getElementById('resTipo').textContent = tipoSel.selectedIndex > 0 ? tipoSel.options[tipoSel.selectedIndex].text : '-';
            document.getElementById('resOpcion').textContent = opcionSel.selectedIndex > 0 ? opcionSel.options[opcionSel.selectedIndex].text : '-';
            document.getElementById('resColor').textContent = colorSel.selectedIndex > 0 ? colorSel.options[colorSel.selectedIndex].text : '-';
            document.getElementById('resDetalle').textContent = detalleSel.selectedIndex > 0 ? detalleSel.options[detalleSel.selectedIndex].text : '-';

            var medidas = '-';
            if (anchoVal && altoVal) {
                medidas = anchoVal + ' x ' + altoVal;
            } else if (anchoVal) {
                medidas = anchoVal + ' x -';
            } else if (altoVal) {
                medidas = '- x ' + altoVal;
            }
            document.getElementById('resMedidas').textContent = medidas;
        }

        // Event listeners
        precioInput.addEventListener('input', calcularPrecio);
        cantidadInput.addEventListener('input', calcularPrecio);
        descuentoInput.addEventListener('input', calcularPrecio);

        // Event listener para tipo de producto
        document.getElementById('tipo').addEventListener('change', function() {
            actualizarOpciones();
            actualizarDescripcionProducto();
            actualizarResumenDetalles();
        });

        // Event listeners para actualizar descripcion
        document.getElementById('opcion').addEventListener('change', function() { actualizarDescripcionProducto(); actualizarResumenDetalles(); });
        document.getElementById('color').addEventListener('change', function() { actualizarDescripcionProducto(); actualizarResumenDetalles(); });

        // Event listener para tipo de detalle
        document.getElementById('tipoDetalle').addEventListener('change', function() { actualizarDetalles(); actualizarResumenDetalles(); });
        document.getElementById('detalle').addEventListener('change', actualizarResumenDetalles);
        document.getElementById('ancho').addEventListener('input', actualizarResumenDetalles);
        document.getElementById('alto').addEventListener('input', actualizarResumenDetalles);

        document.getElementById('btnAgregarItem').addEventListener('click', function() {
            agregarItem();
        });
        document.getElementById('btnNuevoPresupuesto').addEventListener('click', nuevoPresupuesto);

        // === FUNCIONALIDAD DE VISTA PREVIA ===

        // Obtener siguiente numero de presupuesto
        let numeroPresupuesto = '00001';
        fetch('/api/presupuesto/siguiente-numero')
            .then(response => response.json())
            .then(data => {
                if (data.numero) {
                    numeroPresupuesto = data.numero;
                }
            })
            .catch(() => {
                // Usar numero por defecto si hay error
            });

        // Mostrar vista previa del presupuesto
        function mostrarVistaPrevia() {
            if (items.length === 0) {
                return; // No mostrar si no hay items
            }

            // Actualizar numero y fecha
            document.getElementById('previewNumero').textContent = numeroPresupuesto;
            document.getElementById('previewFecha').textContent = new Date().toLocaleDateString('es-AR', { timeZone: 'America/Argentina/Buenos_Aires' });

            // Actualizar datos del cliente
            document.getElementById('previewClienteNombre').textContent = clienteNombreInput.value || '-';
            document.getElementById('previewClienteDireccion').textContent = clienteDireccionInput.value || '-';
            document.getElementById('previewClienteTelefono').textContent = clienteTelefonoInput.value || '-';
            document.getElementById('previewClienteEmail').textContent = clienteEmailInput.value || '-';
            document.getElementById('previewClienteFax').textContent = clienteFaxInput.value || '-';

            // Renderizar items en la tabla de preview
            renderPreviewItems();

            // Calcular totales
            calcularTotalesPreview();

            // Mostrar modal
            $('#modalVistaPrevia').modal('show');
        }

        // Renderizar items en el preview
        function renderPreviewItems() {
            const tbody = document.getElementById('previewItemsBody');
            tbody.innerHTML = '';

            if (items.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-4">No hay items agregados</td></tr>';
                return;
            }

            items.forEach((item, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>
                        <strong>${item.tipo}</strong>
                        <br><small class="text-muted">${item.color} - ${item.opcion}</small>
                        ${item.detalle !== '-' ? '<br><small class="text-muted">' + item.tipoDetalle + ': ' + item.detalle + '</small>' : ''}
                        ${item.ancho || item.alto ? '<br><small class="text-muted">' + item.ancho + ' x ' + item.alto + ' cm</small>' : ''}
                    </td>
                    <td>${item.cantidad}</td>
                    <td>$${item.precioUnitario.toFixed(2)}</td>
                    <td>${item.descuento}%</td>
                    <td class="font-weight-bold">$${item.total.toFixed(2)}</td>
                `;
                tbody.appendChild(row);
            });
        }

        // Calcular totales del preview
        function calcularTotalesPreview() {
            const subtotal = items.reduce((sum, item) => sum + item.total, 0);
            const aplicaIVA = document.getElementById('previewAplicaIVA').value === '1';
            const iva = aplicaIVA ? subtotal * 0.21 : 0;
            const total = subtotal + iva;

            document.getElementById('previewSubtotal').textContent = '$ ' + subtotal.toFixed(0);
            document.getElementById('previewIVA').textContent = '$ ' + iva.toFixed(0);
            document.getElementById('previewTotal').textContent = '$ ' + total.toFixed(0);
        }

        // Event listener para cambio de IVA
        document.getElementById('previewAplicaIVA').addEventListener('change', calcularTotalesPreview);

        // Boton para descargar PDF
        document.getElementById('btnDescargarPDF').addEventListener('click', function() {
            // Guardar primero el presupuesto
            guardarPresupuestoYDescargarPDF();
        });

        // Guardar presupuesto y luego descargar PDF
        function guardarPresupuestoYDescargarPDF() {
            const presupuestoData = {
                numero: numeroPresupuesto,
                fecha: new Date().toLocaleDateString('en-CA', { timeZone: 'America/Argentina/Buenos_Aires' }),
                cliente_id: clienteIdInput.value || null,
                cliente_nombre: clienteNombreInput.value,
                cliente_direccion: clienteDireccionInput.value,
                cliente_telefono: clienteTelefonoInput.value,
                cliente_email: clienteEmailInput.value,
                cliente_fax: clienteFaxInput.value,
                cliente_registro: '',
                observacion: document.getElementById('previewObservacion').value,
                aplica_iva: document.getElementById('previewAplicaIVA').value === '1',
                items: items.map(item => ({
                    tipo_producto: item.tipo,
                    modelo: item.opcion,
                    color_aluminio: item.color,
                    tipo_detalle: item.tipoDetalle,
                    detalle: item.detalle,
                    ancho: item.ancho,
                    alto: item.alto,
                    cantidad: item.cantidad,
                    precio_unitario: item.precioUnitario,
                    descuento_porcentaje: item.descuento,
                    total: item.total
                }))
            };

            const saveUrl = window.presupuestoEditarId
                ? '/api/presupuesto/' + window.presupuestoEditarId + '/actualizar'
                : '/api/presupuesto/guardar';
            const saveMethod = window.presupuestoEditarId ? 'PUT' : 'POST';

            fetch(saveUrl, {
                method: saveMethod,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(presupuestoData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Abrir ventana de impresion/PDF
                    imprimirPresupuesto(data.presupuesto.id);
                } else {
                    mostrarAlerta('danger', 'Error al guardar: ' + (data.message || 'Error desconocido'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarAlerta('danger', 'Error al guardar el presupuesto');
            });
        }

        // Funcion para descargar el presupuesto como PDF
        function imprimirPresupuesto(presupuestoId) {
            // Mostrar loading screen
            var loader = document.getElementById('loading-screen');
            if (loader) {
                loader.querySelector('.loading-text').textContent = 'Generando PDF...';
                loader.classList.remove('hidden');
                loader.style.display = 'flex';
            }

            // Cerrar modal
            $('#modalVistaPrevia').modal('hide');

            // Descargar PDF via fetch para no bloquear la página
            fetch('/dashboard/presupuesto/' + presupuestoId + '/descargar-pdf')
                .then(response => {
                    if (!response.ok) throw new Error('Error al generar PDF');
                    var filename = 'Presupuesto_' + presupuestoId + '.pdf';
                    var disposition = response.headers.get('Content-Disposition');
                    if (disposition) {
                        var match = disposition.match(/filename="?([^"]+)"?/);
                        if (match) filename = match[1];
                    }
                    return response.blob().then(blob => ({ blob, filename }));
                })
                .then(({ blob, filename }) => {
                    var url = window.URL.createObjectURL(blob);
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = filename;
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    a.remove();
                })
                .catch(error => {
                    console.error('Error:', error);
                    mostrarAlerta('danger', 'Error al descargar el PDF');
                })
                .finally(() => {
                    // Ocultar loading screen
                    if (loader) {
                        loader.classList.add('hidden');
                        setTimeout(function() {
                            loader.style.display = 'none';
                            loader.querySelector('.loading-text').textContent = 'Cargando...';
                        }, 500);
                    }
                });

            // Actualizar numero para el siguiente presupuesto
            fetch('/api/presupuesto/siguiente-numero')
                .then(response => response.json())
                .then(data => {
                    if (data.numero) {
                        numeroPresupuesto = data.numero;
                    }
                });

            // Limpiar items pero mantener datos del cliente
            limpiarItemsYFormulario();
        }

        // Guardar presupuesto en la base de datos
        function guardarPresupuesto() {
            const presupuestoData = {
                numero: numeroPresupuesto,
                fecha: new Date().toLocaleDateString('en-CA', { timeZone: 'America/Argentina/Buenos_Aires' }),
                cliente_id: clienteIdInput.value || null,
                cliente_nombre: clienteNombreInput.value,
                cliente_direccion: clienteDireccionInput.value,
                cliente_telefono: clienteTelefonoInput.value,
                cliente_email: clienteEmailInput.value,
                cliente_fax: clienteFaxInput.value,
                cliente_registro: '',
                observacion: document.getElementById('previewObservacion').value,
                aplica_iva: document.getElementById('previewAplicaIVA').value === '1',
                items: items.map(item => ({
                    tipo_producto: item.tipo,
                    modelo: item.opcion,
                    color_aluminio: item.color,
                    tipo_detalle: item.tipoDetalle,
                    detalle: item.detalle,
                    ancho: item.ancho,
                    alto: item.alto,
                    cantidad: item.cantidad,
                    precio_unitario: item.precioUnitario,
                    descuento_porcentaje: item.descuento,
                    total: item.total
                }))
            };

            const saveUrl = window.presupuestoEditarId
                ? '/api/presupuesto/' + window.presupuestoEditarId + '/actualizar'
                : '/api/presupuesto/guardar';
            const saveMethod = window.presupuestoEditarId ? 'PUT' : 'POST';

            fetch(saveUrl, {
                method: saveMethod,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(presupuestoData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (window.presupuestoEditarId) {
                        mostrarAlerta('success', 'Presupuesto N° ' + data.presupuesto.numero + ' actualizado correctamente');
                        $('#modalVistaPrevia').modal('hide');
                        setTimeout(function() { window.location.href = '/dashboard/ventas'; }, 1500);
                    } else {
                        mostrarAlerta('success', 'Presupuesto guardado exitosamente - N° ' + data.presupuesto.numero);
                        $('#modalVistaPrevia').modal('hide');
                        fetch('/api/presupuesto/siguiente-numero')
                            .then(response => response.json())
                            .then(data => {
                                if (data.numero) {
                                    numeroPresupuesto = data.numero;
                                }
                            });
                        limpiarItemsYFormulario();
                    }
                } else {
                    mostrarAlerta('danger', 'Error al guardar: ' + (data.message || 'Error desconocido'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarAlerta('danger', 'Error al guardar el presupuesto');
            });
        }

        // Boton Exportar PDF (en el header de la pagina)
        document.getElementById('btnExportarPDF').addEventListener('click', function() {
            if (items.length === 0) {
                mostrarAlerta('warning', 'Agrega al menos un item al presupuesto');
                return;
            }
            mostrarVistaPrevia();
        });

        // === MODO EDICION: pre-cargar presupuesto existente ===
        @if(isset($presupuestoEditar) && $presupuestoEditar)
        (function() {
            const pEdit = @json($presupuestoEditar);
            window.presupuestoEditarId = pEdit.id;
            numeroPresupuesto = pEdit.numero;

            // Banner de edicion
            const banner = document.createElement('div');
            banner.className = 'alert alert-warning alert-dismissible mb-0';
            banner.style.cssText = 'border-radius:0; border-left:none; border-right:none; border-top:none;';
            banner.innerHTML = '<i class="fa-solid fa-pen-to-square mr-2"></i><strong>Modo edicion:</strong> Presupuesto N° ' + pEdit.numero +
                ' — Guardá los cambios con el botón "Exportar / Guardar PDF".' +
                '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>';
            document.querySelector('.container-fluid').prepend(banner);

            // Pre-poblar datos del cliente
            document.getElementById('clienteId').value = pEdit.cliente_id || '';
            document.getElementById('clienteNombre').value = pEdit.cliente_nombre || '';
            document.getElementById('clienteDireccion').value = pEdit.cliente_direccion || '';
            document.getElementById('clienteTelefono').value = pEdit.cliente_telefono || '';
            document.getElementById('clienteEmail').value = pEdit.cliente_email || '';
            document.getElementById('clienteFax').value = pEdit.cliente_fax || '';
            document.getElementById('previewObservacion').value = pEdit.observacion || '';

            // Pre-poblar items
            if (pEdit.items && pEdit.items.length > 0) {
                items = pEdit.items.map(function(item) {
                    itemCounter++;
                    return {
                        id: itemCounter,
                        tipo: item.tipo_producto || '',
                        opcion: item.modelo || '-',
                        color: item.color_aluminio || '-',
                        tipoDetalle: '-',
                        detalle: '-',
                        ancho: parseFloat(item.ancho) || 0,
                        alto: parseFloat(item.alto) || 0,
                        cantidad: parseInt(item.cantidad) || 1,
                        precioUnitario: parseFloat(item.precio_unitario) || 0,
                        descuento: parseFloat(item.descuento_porcentaje) || 0,
                        total: parseFloat(item.total) || 0
                    };
                });
                renderItems();
                actualizarTotalPresupuesto();
            }

            // Ir directo a la tab Detalles en modo edicion
            setTimeout(function() {
                $('#detalles-tab').tab('show');
            }, 0);
        })();
        @endif

        // Tab styling + mostrar/ocultar panel de precio
        $('#presupuestoTabs .nav-link').on('shown.bs.tab', function(e) {
            $('#presupuestoTabs .nav-link').removeClass('text-white').addClass('text-white-50');
            $(e.target).removeClass('text-white-50').addClass('text-white');

            var tabId = $(e.target).attr('href');
            if (tabId === '#cliente') {
                $('#panelPrecio').hide();
                $('#panelFormulario').removeClass('col-lg-8').addClass('col-lg-12');
            } else {
                $('#panelPrecio').show();
                $('#panelFormulario').removeClass('col-lg-12').addClass('col-lg-8');
            }
        });

        // === FUNCIONALIDAD DE CLIENTES ===

        const clienteSearchInput = document.getElementById('clienteSearch');
        const clienteSearchResults = document.getElementById('clienteSearchResults');
        const clienteIdInput = document.getElementById('clienteId');
        const clienteNombreInput = document.getElementById('clienteNombre');
        const clienteDireccionInput = document.getElementById('clienteDireccion');
        const clienteTelefonoInput = document.getElementById('clienteTelefono');
        const clienteEmailInput = document.getElementById('clienteEmail');
        const clienteFaxInput = document.getElementById('clienteFax');

        let searchTimeout = null;

        // Buscar clientes mientras escribe
        clienteSearchInput.addEventListener('input', function() {
            const query = this.value.trim();

            if (searchTimeout) clearTimeout(searchTimeout);

            if (query.length < 2) {
                clienteSearchResults.style.display = 'none';
                return;
            }

            searchTimeout = setTimeout(() => {
                fetch(`/api/clientes/buscar?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(clientes => {
                        if (clientes.length > 0) {
                            clienteSearchResults.innerHTML = clientes.map(c => `
                                <a href="#" class="list-group-item list-group-item-action py-2" data-cliente='${JSON.stringify(c)}'>
                                    <strong>${c.nombre}</strong>
                                    <br><small class="text-muted">${c.telefono || ''} ${c.email ? '- ' + c.email : ''}</small>
                                </a>
                            `).join('');
                            clienteSearchResults.style.display = 'block';
                        } else {
                            clienteSearchResults.innerHTML = '<div class="list-group-item text-muted py-2">No se encontraron clientes</div>';
                            clienteSearchResults.style.display = 'block';
                        }
                    })
                    .catch(error => {
                        console.error('Error buscando clientes:', error);
                    });
            }, 300);
        });

        // Seleccionar cliente de la lista
        clienteSearchResults.addEventListener('click', function(e) {
            const item = e.target.closest('[data-cliente]');
            if (item) {
                e.preventDefault();
                const cliente = JSON.parse(item.dataset.cliente);
                cargarDatosCliente(cliente);
                clienteSearchResults.style.display = 'none';
                clienteSearchInput.value = '';
            }
        });

        // Ocultar resultados al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (!clienteSearchResults.contains(e.target) && e.target !== clienteSearchInput) {
                clienteSearchResults.style.display = 'none';
            }
        });

        // Cargar datos del cliente en el formulario
        function cargarDatosCliente(cliente) {
            clienteIdInput.value = cliente.id;
            clienteNombreInput.value = cliente.nombre || '';
            clienteDireccionInput.value = cliente.direccion || '';
            clienteTelefonoInput.value = cliente.telefono || '';
            clienteEmailInput.value = cliente.email || '';
            clienteFaxInput.value = cliente.fax || '';
        }

        // Limpiar formulario de cliente
        function limpiarFormularioCliente() {
            clienteIdInput.value = '';
            clienteNombreInput.value = '';
            clienteDireccionInput.value = '';
            clienteTelefonoInput.value = '';
            clienteEmailInput.value = '';
            clienteFaxInput.value = '';
            clienteSearchInput.value = '';
        }

        // Boton nuevo cliente
        document.getElementById('btnNuevoCliente').addEventListener('click', function() {
            limpiarFormularioCliente();
            clienteNombreInput.focus();
        });

        // Guardar cliente
        document.getElementById('btnGuardarCliente').addEventListener('click', function() {
            const nombre = clienteNombreInput.value.trim();

            if (!nombre) {
                mostrarAlerta('warning', 'El nombre del cliente es requerido');
                clienteNombreInput.focus();
                return;
            }

            const clienteData = {
                nombre: nombre,
                direccion: clienteDireccionInput.value.trim(),
                telefono: clienteTelefonoInput.value.trim(),
                email: clienteEmailInput.value.trim(),
                fax: clienteFaxInput.value.trim()
            };

            const clienteId = clienteIdInput.value;
            const url = clienteId ? `/api/clientes/${clienteId}` : '/api/clientes';
            const method = clienteId ? 'PUT' : 'POST';

            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(clienteData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarAlerta('success', data.message);
                    clienteIdInput.value = data.cliente.id;
                } else {
                    mostrarAlerta('danger', 'Error al guardar el cliente');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarAlerta('danger', 'Error al guardar el cliente');
            });
        });

        // Inicializar
        actualizarDescripcionProducto();
        calcularPrecio();
    </script>
    @endsection

</x-dashboard-layout>
