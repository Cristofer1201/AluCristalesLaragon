<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Presupuesto #{{ $presupuesto->numero }}</title>
    <style>
        @page {
            margin: 40px 0 30px 0;
        }

        @page :first {
            margin-top: 0;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .content-wrapper {
            padding: 0 20px;
        }

        /* ===== HEADER ===== */
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-left {
            background-color: #ffffff;
            color: white;
            vertical-align: top;
            padding: 0;
            width: 55%;
        }

        .header-left-inner {
            background-color: #cc0000;
            height: 140px;
            overflow: hidden;
            padding: 0 10px;
        }

        .header-right {
            background-color: #ffffff;
            color: #333;
            vertical-align: middle;
            padding: 15px 40px 15px 20px;
            width: 45%;
            text-align: right;
        }

        .logo-table {
            border-collapse: collapse;
        }

        .logo-table td {
            vertical-align: middle;
            padding: 0 5px 0 0;
            color: white;
        }

        .company-name {
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .company-subtitle {
            font-size: 16px;
            letter-spacing: 4px;
        }

        .presupuesto-h1 {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .presupuesto-numero {
            font-size: 18px;
            color: #333;
            margin-bottom: 5px;
        }

        .presupuesto-nota {
            font-size: 10px;
            font-weight: normal;
            color: #555;
        }

        /* ===== INFO + FECHA ===== */
        .info-fecha-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .info-fecha-table td {
            vertical-align: top;
            padding: 5px 0;
        }

        .info-cell {
            font-size: 12px;
            line-height: 1.8;
        }

        .fecha-box {
            background-color: #cc0000;
            color: white;
            padding: 10px 15px;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
        }

        /* ===== CLIENTE ===== */
        .cliente-section {
            margin: 5px 0;
            padding: 5px 0;
        }

        .cliente-section h3 {
            color: #cc0000;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .cliente-table {
            width: 100%;
            border-collapse: collapse;
        }

        .cliente-table td {
            padding: 3px 0;
            font-size: 12px;
        }

        .cliente-label {
            font-weight: bold;
            width: 90px;
        }

        .cliente-value {
            border-bottom: 1px solid #333;
        }

        /* ===== PRODUCTO ===== */
        .producto-table {
            width: 100%;
            border: 2px solid #333;
            border-collapse: collapse;
            margin: 12px 0;
            page-break-inside: avoid;
        }

        .producto-table td {
            border: 2px solid #333;
            vertical-align: top;
            padding: 12px;
        }

        .producto-img-cell {
            width: 28%;
            text-align: center;
            vertical-align: middle;
        }

        .producto-detalles-cell {
            width: 42%;
        }

        .producto-espec-cell {
            width: 30%;
        }

        .section-title {
            text-align: center;
            margin-bottom: 10px;
            font-size: 13px;
            font-weight: bold;
            padding-bottom: 8px;
            border-bottom: 2px solid #333;
        }

        .detalle-item {
            margin: 5px 0;
            font-size: 11px;
        }

        /* ===== VENTANA PLACEHOLDER ===== */
        .ventana-placeholder {
            width: 120px;
            height: 120px;
            border: 3px solid #8B6914;
            background-color: #87CEEB;
            margin: 0 auto;
        }

        /* ===== OBSERVACION ===== */
        .observacion {
            margin: 12px 0;
            padding: 10px;
            background-color: transparent;
        }

        .observacion h4 {
            margin-bottom: 8px;
            font-size: 15px;
        }

        .observacion p {
            font-size: 12px;
            line-height: 1.6;
        }

        .cliente-nota {
            color: #cc0000;
            font-weight: bold;
            margin-top: 8px;
        }

        /* ===== TOTALES ===== */
        .totales-wrapper {
            margin: 12px 0;
            text-align: right;
        }

        .totales-table {
            margin-left: auto;
            border-collapse: collapse;
        }

        .totales-table td {
            padding: 8px 15px;
            border: 2px solid #333;
            font-size: 14px;
        }

        .totales-label {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        /* ===== WATERMARK ===== */
        .watermark {
            position: fixed;
            top: 250px;
            left: 0;
            width: 100%;
            text-align: center;
            opacity: 0.15;
            z-index: -1;
        }
    </style>
</head>
<body>
    {{-- Watermark --}}
    @php
        $watermarkPath = public_path('img/pdf/Logo fondo presupuesto.png');
    @endphp
    @if(file_exists($watermarkPath))
        <div class="watermark">
            <img src="{{ $watermarkPath }}" style="width: 600px;">
        </div>
    @endif

    {{-- Header (full width, outside wrapper) --}}
    <table class="header-table" cellpadding="0" cellspacing="0">
        <tr>
            <td class="header-left">
                <div class="header-left-inner">
                    <table class="logo-table" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                @php
                                    $logoPath = public_path('img/pdf/Logo blanco.png');
                                @endphp
                                @if(file_exists($logoPath))
                                    <img src="{{ $logoPath }}" alt="Logo" style="width: 150px; height: 150px;">
                                @endif
                            </td>
                            <td>
                                <div class="company-name">ALUCRISTALES</div>
                                <div class="company-subtitle">PALERMO</div>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
            <td class="header-right">
                <div class="presupuesto-h1">PRESUPUESTO</div>
                <div class="presupuesto-numero">Nro {{ $presupuesto->numero }}</div>
                <div class="presupuesto-nota">Documento no v&aacute;lido como Factura</div>
            </td>
        </tr>
    </table>

    {{-- Content with padding --}}
    <div class="content-wrapper">

        {{-- Info de contacto + Fecha --}}
        <table class="info-fecha-table" cellpadding="0" cellspacing="0">
            <tr>
                <td class="info-cell">
                    <div><strong>OFICINAS:</strong> {{ strtoupper($empresa->direccion ?? 'Araoz 2403 / Guemes 4888 / Palermo (CABA)') }}</div>
                    <div><strong>TELEFONOS:</strong> {{ $empresa->telefono1 ?? '' }}{{ $empresa->telefono2 ? ' / ' . $empresa->telefono2 : '' }}</div>
                    <div><strong>CORREO:</strong> {{ $empresa->email ?? '' }}</div>
                </td>
                <td style="width: 160px; text-align: right;">
                    <div class="fecha-box">
                        FECHA:<br>{{ $presupuesto->fecha->format('d/m/Y') }}
                    </div>
                </td>
            </tr>
        </table>

        {{-- Información del cliente --}}
        <div class="cliente-section">
            <h3>INFORMACION DEL CLIENTE:</h3>
            <table class="cliente-table" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="cliente-label">NOMBRE:</td>
                    <td class="cliente-value">{{ $presupuesto->cliente_nombre ?? '' }}</td>
                    <td style="width: 50px;"></td>
                    <td style="width: 120px;"></td>
                </tr>
                <tr>
                    <td class="cliente-label">DIRECCION:</td>
                    <td class="cliente-value">{{ $presupuesto->cliente_direccion ?? '' }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="cliente-label">TELEFONO:</td>
                    <td class="cliente-value">{{ $presupuesto->cliente_telefono ?? '' }}</td>
                    <td class="cliente-label" style="text-align: right;">FAX:</td>
                    <td class="cliente-value">{{ $presupuesto->cliente_fax ?? '' }}</td>
                </tr>
                <tr>
                    <td class="cliente-label">EMAIL:</td>
                    <td class="cliente-value">{{ $presupuesto->cliente_email ?? '' }}</td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>

        {{-- Items del presupuesto --}}
        @foreach($presupuesto->items as $item)
        <table class="producto-table" cellpadding="0" cellspacing="0">
            <tr>
                <td class="producto-img-cell">
                    @php
                        $modeloKey = mb_strtolower(trim($item->modelo ?? ''));
                        $tipoKey = mb_strtolower(trim($item->tipo_producto ?? ''));
                        $imagenRelPath = $productoImagenes[$modeloKey] ?? $productoImagenes[$tipoKey] ?? null;
                        $imagenFullPath = $imagenRelPath ? public_path($imagenRelPath) : null;
                    @endphp
                    @if($imagenFullPath && file_exists($imagenFullPath))
                        <img src="{{ $imagenFullPath }}" alt="{{ $item->modelo ?? $item->tipo_producto }}"
                             style="width: 140px; height: auto; display: block; margin: 0 auto;">
                    @else
                        <div class="ventana-placeholder"></div>
                    @endif
                </td>

                <td class="producto-detalles-cell">
                    <div class="section-title">DETALLES Y PRECIO</div>
                    <div class="detalle-item"><strong>Tipo:</strong> {{ strtoupper($item->tipo_producto ?? 'N/A') }}</div>
                    <div class="detalle-item"><strong>Opci&oacute;n:</strong> {{ $item->modelo ?? 'N/A' }}</div>
                    <div class="detalle-item"><strong>Color de Aluminio:</strong> {{ $item->color_aluminio ?? 'N/A' }}</div>
                    <div class="detalle-item"><strong>Altura:</strong> {{ $item->alto ?? '-' }} <strong>Ancho:</strong> {{ $item->ancho ?? '-' }}</div>
                    <div class="detalle-item"><strong>Detalle:</strong> {{ $item->descripcion ?? 'N/A' }}</div>
                    <div class="detalle-item"><strong>Precio:</strong> {{ number_format($item->precio_unitario, 0, ',', '.') }} <strong>Cantidad:</strong> {{ $item->cantidad }}</div>
                    <div class="detalle-item"><strong>Descuento:</strong> {{ $item->descuento_porcentaje ?? 0 }}</div>
                    <div class="detalle-item"><strong>Total:</strong> {{ number_format($item->total, 0, ',', '.') }}</div>
                </td>

                <td class="producto-espec-cell">
                    <div class="section-title">ESPECIFICACIONES</div>
                    <div class="detalle-item"><strong>Premarco:</strong> {{ $item->premarco ?? 'N/A' }}</div>
                    <div class="detalle-item"><strong>Tapajuntas:</strong> {{ $item->tapajuntas ?? 'N/A' }}</div>
                    <div class="detalle-item"><strong>Angulo:</strong> {{ $item->angulo ?? 'N/A' }}</div>
                    <div class="detalle-item"><strong>Linea:</strong> {{ $item->linea ?? 'N/A' }}</div>
                    <div class="detalle-item"><strong>Opcional:</strong> N/A</div>
                </td>
            </tr>
        </table>
        @endforeach

        {{-- Observación + Totales lado a lado --}}
        <table style="width: 100%; margin: 12px 0; border-collapse: collapse;" cellpadding="0" cellspacing="0">
            <tr>
                <td style="vertical-align: top; width: 60%; padding-right: 10px;">
                    <div class="observacion" style="margin: 0;">
                        <h4>OBSERVACION:</h4>
                        <p>{{ $presupuesto->observacion ?? 'INCLUYE INSTALACION, PRECIO SIN IVA, MEDIDAS APROXIMADAS' }}</p>
                        <p class="cliente-nota">Sr. Cliente:<br>
                        El Presupuesto es v&aacute;lido por 15 d&iacute;as m&aacute;ximo y 10 d&iacute;as m&iacute;nimo.<br>
                        Consultar en administraci&oacute;n los d&iacute;as de fabricaci&oacute;n y los m&eacute;todos de pago.</p>
                    </div>
                </td>
                <td style="vertical-align: bottom; width: 40%;">
                    <table class="totales-table" cellpadding="0" cellspacing="0" style="margin-left: auto;">
                        <tr>
                            <td class="totales-label">SubTotal:</td>
                            <td>$ {{ number_format($presupuesto->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="totales-label">I.V.A. {{ number_format($presupuesto->iva_porcentaje, 0) }}%:</td>
                            <td>
                                @if($presupuesto->aplica_iva)
                                    $ {{ number_format($presupuesto->iva_monto, 0, ',', '.') }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="totales-label">Total:</td>
                            <td>$ {{ number_format($presupuesto->total, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </div>

    {{-- Footer con texto y número de página --}}
    <script type="text/php">
        if (isset($pdf)) {
            $font = $fontMetrics->getFont("Arial", "normal");
            $size = 8;
            $pageHeight = $pdf->get_height();
            $pageWidth = $pdf->get_width();
            $y = $pageHeight - 25;

            // Izquierda: nombre de empresa
            $pdf->page_text(20, $y, "AluCristales Palermo - Presupuesto", $font, $size, array(0.3, 0.3, 0.3));

            // Derecha: contador de página
            $pdf->page_text($pageWidth - 80, $y, "{PAGE_NUM} de {PAGE_COUNT}", $font, $size, array(0.3, 0.3, 0.3));
        }
    </script>
</body>
</html>
