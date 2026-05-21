<x-dashboard-layout>
    <x-slot:pageTitle>Plantilla PDF</x-slot:pageTitle>
    <x-slot:pageSubtitle>Configura los datos de la empresa que aparecen en los presupuestos PDF</x-slot:pageSubtitle>

    <style>
        body.dark-mode .pdf-preview-wrapper {
            background-color: transparent !important;
        }
        body.dark-mode .pdf-preview,
        body.dark-mode .pdf-preview div,
        body.dark-mode .pdf-preview strong,
        body.dark-mode .pdf-preview span,
        body.dark-mode .pdf-preview p,
        body.dark-mode .pdf-preview td {
            color: #333 !important;
        }
    </style>
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
            <!-- Formulario de configuracion -->
            <div class="col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header bg-danger py-3">
                        <h6 class="m-0 font-weight-bold text-white">
                            <i class="fa-solid fa-building mr-2"></i>Datos de la Empresa
                        </h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('dashboard.plantilla-pdf.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="nombre" class="form-label font-weight-bold">Nombre de la Empresa <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $empresa->nombre }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="cuit" class="form-label font-weight-bold">CUIT</label>
                                    <input type="text" class="form-control" id="cuit" name="cuit" value="{{ $empresa->cuit }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="email" class="form-label font-weight-bold">Correo Electronico</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $empresa->email }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="direccion" class="form-label font-weight-bold">Direccion Principal</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" value="{{ $empresa->direccion }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="direccion_alternativa" class="form-label font-weight-bold">Direccion Alternativa</label>
                                    <input type="text" class="form-control" id="direccion_alternativa" name="direccion_alternativa" value="{{ $empresa->direccion_alternativa }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="telefono1" class="form-label font-weight-bold">Telefono 1</label>
                                    <input type="text" class="form-control" id="telefono1" name="telefono1" value="{{ $empresa->telefono1 }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="telefono2" class="form-label font-weight-bold">Telefono 2</label>
                                    <input type="text" class="form-control" id="telefono2" name="telefono2" value="{{ $empresa->telefono2 }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="logo" class="form-label font-weight-bold">Logo de la Empresa</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="logo" name="logo" accept="image/png,image/jpeg">
                                        <label class="custom-file-label" for="logo" data-browse="Examinar">Seleccionar imagen...</label>
                                    </div>
                                    <small class="form-text text-muted">Formatos: PNG, JPG. Tamaño maximo: 2MB</small>
                                </div>
                            </div>

                            @if($empresa->logo)
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label font-weight-bold">Logo Actual:</label>
                                    <div class="border rounded p-3 text-center" style="background: #f8f9fc;">
                                        <img src="{{ asset('storage/' . $empresa->logo) }}" alt="Logo" style="max-height: 80px;">
                                    </div>
                                </div>
                            </div>
                            @endif

                            <hr>
                            <div class="text-right">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa-solid fa-floppy-disk mr-1"></i>
                                    Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Vista previa del PDF -->
            <div class="col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header bg-dark py-3">
                        <h6 class="m-0 font-weight-bold text-white">
                            <i class="fa-solid fa-eye mr-2"></i>Vista Previa
                        </h6>
                    </div>
                    <div class="card-body p-0 pdf-preview-wrapper">
                        <div style="background: #f5f5f5 !important; padding: 15px;">
                            <div class="pdf-preview" style="background: white !important; box-shadow: 0 0 8px rgba(0,0,0,0.1); font-size: 11px; overflow: hidden; color: #333 !important;">
                                <!-- Header Preview -->
                                <div style="background: #cc0000; color: white; padding: 10px 15px; display: flex; justify-content: space-between; align-items: center;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        @if($empresa->logo)
                                            <img src="{{ asset('storage/' . $empresa->logo) }}" alt="Logo" style="height: 40px; filter: brightness(2);">
                                        @else
                                            <img src="{{ asset('img/Logo Alucristales blanco.png') }}" alt="Logo" style="height: 40px;">
                                        @endif
                                        <div>
                                            <div style="font-size: 14px; font-weight: bold; letter-spacing: 1px;">{{ strtoupper($empresa->nombre) }}</div>
                                        </div>
                                    </div>
                                    <div style="text-align: right;">
                                        <div style="font-size: 14px; font-weight: bold;">PRESUPUESTO</div>
                                        <div style="font-size: 11px;">Nro 0001</div>
                                    </div>
                                </div>

                                <!-- Info Preview -->
                                <div style="padding: 10px 15px; display: flex; justify-content: space-between; align-items: flex-start;">
                                    <div style="font-size: 9px; line-height: 1.6; flex: 1;">
                                        <div><strong>OFICINAS:</strong> {{ strtoupper($empresa->direccion ?? '-') }}</div>
                                        <div><strong>TELEFONOS:</strong> {{ $empresa->telefono1 ?? '-' }}{{ $empresa->telefono2 ? ' / ' . $empresa->telefono2 : '' }}</div>
                                        <div><strong>CORREO:</strong> {{ $empresa->email ?? '-' }}</div>
                                    </div>
                                    <div style="background: #cc0000; color: white; padding: 6px 12px; text-align: center; font-size: 9px; font-weight: bold; white-space: nowrap; margin-left: 10px;">
                                        FECHA:<br>{{ date('d/m/Y') }}
                                    </div>
                                </div>

                                <!-- Cliente Preview -->
                                <div style="margin: 8px 15px; padding: 8px; border: 1.5px solid #cc0000; font-size: 9px;">
                                    <div style="color: #cc0000; font-weight: bold; margin-bottom: 5px; font-size: 9px;">INFORMACION DEL CLIENTE:</div>
                                    <div><strong>NOMBRE:</strong> ____________________________</div>
                                    <div><strong>DIRECCION:</strong> __________________________</div>
                                    <div><strong>TELEFONO:</strong> __________ <strong>FAX:</strong> __________</div>
                                </div>

                                <!-- Items Preview -->
                                <div style="margin: 8px 15px; border: 1.5px solid #333; display: grid; grid-template-columns: 1fr 1.5fr 1fr; font-size: 8px;">
                                    <div style="padding: 8px; border-right: 1.5px solid #333; display: flex; align-items: center; justify-content: center;">
                                        <div style="width: 60px; height: 60px; border: 2px solid #8B6914; background: #87CEEB;"></div>
                                    </div>
                                    <div style="padding: 8px; border-right: 1.5px solid #333;">
                                        <div style="text-align: center; font-weight: bold; border-bottom: 1px solid #333; padding-bottom: 4px; margin-bottom: 6px;">DETALLES Y PRECIO</div>
                                        <div><strong>Tipo:</strong> EJEMPLO</div>
                                        <div><strong>Precio:</strong> 0 <strong>Cant:</strong> 1</div>
                                        <div><strong>Total:</strong> 0</div>
                                    </div>
                                    <div style="padding: 8px;">
                                        <div style="text-align: center; font-weight: bold; border-bottom: 1px solid #333; padding-bottom: 4px; margin-bottom: 6px;">ESPECIFICACIONES</div>
                                        <div><strong>Premarco:</strong> N/A</div>
                                        <div><strong>Linea:</strong> N/A</div>
                                    </div>
                                </div>

                                <!-- Totales Preview -->
                                <div style="margin: 8px 15px 15px; text-align: right;">
                                    <table style="margin-left: auto; border-collapse: collapse; font-size: 9px;">
                                        <tr>
                                            <td style="padding: 4px 8px; border: 1px solid #333; background: #f0f0f0; font-weight: bold;">SubTotal:</td>
                                            <td style="padding: 4px 8px; border: 1px solid #333;">$ 0</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 4px 8px; border: 1px solid #333; background: #f0f0f0; font-weight: bold;">I.V.A. 21%:</td>
                                            <td style="padding: 4px 8px; border: 1px solid #333;">$ 0</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 4px 8px; border: 1px solid #333; background: #f0f0f0; font-weight: bold;">Total:</td>
                                            <td style="padding: 4px 8px; border: 1px solid #333;">$ 0</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="card shadow mb-4 border-left-info">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-circle-info fa-2x text-info mr-3"></i>
                            <div>
                                <h6 class="font-weight-bold text-info mb-1">Informacion</h6>
                                <p class="text-muted small mb-0">
                                    Los datos configurados aqui se mostraran automaticamente en todos los presupuestos PDF que generes.
                                    La vista previa es una representacion aproximada del documento final.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('otherScripts')
    <script>
        $(document).ready(function() {
            // Mostrar nombre del archivo seleccionado en el input file
            $('.custom-file-input').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').html(fileName || 'Seleccionar imagen...');
            });
        });
    </script>
    @endsection
</x-dashboard-layout>
