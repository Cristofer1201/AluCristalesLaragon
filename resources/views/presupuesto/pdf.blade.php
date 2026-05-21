<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presupuesto #{{ $presupuesto->numero }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .presupuesto-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }

        /* ===== WATERMARK ===== */
        .watermark {
            position: absolute;
            top: 55%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.12;
            z-index: 0;
            pointer-events: none;
        }

        .watermark img {
            width: 500px;
            height: auto;
        }

        .header {
            background: #cc0000;
            color: white;
            padding: 5px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo img {
            width: 200px;
            height: 200px;
            object-fit: contain;
            filter: brightness(2);
        }

        .company-name {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .company-subtitle {
            font-size: 18px;
            letter-spacing: 4px;
            margin-top: -5px;
        }

        .presupuesto-title {
            text-align: right;
        }

        .presupuesto-title h1 {
            font-size: 36px;
            margin-bottom: 5px;
        }

        .presupuesto-title .numero {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .presupuesto-title .nota {
            font-size: 12px;
            font-weight: normal;
        }

        .info-fecha-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 20px 30px;
            position: relative;
            z-index: 1;
        }

        .info-section {
            font-size: 13px;
            line-height: 1.6;
            flex: 1;
        }

        .fecha-box {
            background: #cc0000;
            color: white;
            padding: 12px 25px;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            white-space: nowrap;
            margin-left: 20px;
        }

        .cliente-info {
            margin: 20px 30px;
            padding: 15px;
            border: 2px solid #cc0000;
            position: relative;
            z-index: 1;
        }

        .cliente-info h3 {
            color: #cc0000;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .cliente-info table {
            width: 100%;
        }

        .cliente-info td {
            padding: 5px 0;
            font-size: 13px;
        }

        .cliente-info td:first-child {
            font-weight: bold;
            width: 120px;
        }

        .cliente-info td:nth-child(2) {
            border-bottom: 1px solid #333;
        }

        .producto-section {
            display: grid;
            grid-template-columns: 1fr 1.5fr 1fr;
            margin: 20px 30px;
            border: 2px solid #333;
            position: relative;
            z-index: 1;
            page-break-inside: avoid;
        }

        .producto-imagen {
            padding: 20px;
            border-right: 2px solid #333;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .producto-imagen img {
            max-width: 100%;
            height: auto;
        }

        .ventana-preview {
            width: 180px;
            height: 180px;
            border: 3px solid #8B6914;
            background: #87CEEB;
            position: relative;
        }

        .ventana-preview::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            width: 3px;
            height: 60%;
            background: #8B6914;
            transform: translateX(-50%);
        }

        .ventana-preview::after {
            content: '';
            position: absolute;
            top: 60%;
            left: 0;
            width: 100%;
            height: 3px;
            background: #8B6914;
        }

        .detalles-precio {
            padding: 20px;
            border-right: 2px solid #333;
        }

        .detalles-precio h3,
        .especificaciones h3 {
            text-align: center;
            margin-bottom: 15px;
            font-size: 14px;
            padding-bottom: 10px;
            border-bottom: 2px solid #333;
        }

        .detalle-item {
            margin: 8px 0;
            font-size: 13px;
        }

        .detalle-item strong {
            display: inline-block;
            min-width: 100px;
        }

        .especificaciones {
            padding: 20px;
        }

        .observacion {
            margin: 20px 30px;
            padding: 15px;
            background: #f9f9f9;
            position: relative;
            z-index: 1;
        }

        .observacion h4 {
            margin-bottom: 10px;
            font-size: 14px;
        }

        .observacion p {
            font-size: 12px;
            line-height: 1.6;
        }

        .cliente-nota {
            color: #cc0000;
            font-weight: bold;
            margin-top: 10px;
        }

        .totales {
            margin: 20px 30px;
            text-align: right;
            position: relative;
            z-index: 1;
        }

        .totales table {
            margin-left: auto;
            border-collapse: collapse;
        }

        .totales td {
            padding: 8px 15px;
            border: 2px solid #333;
            font-size: 14px;
        }

        .totales td:first-child {
            background: #f0f0f0;
            font-weight: bold;
        }

        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
            }
            .presupuesto-container {
                box-shadow: none;
                max-width: 100%;
                width: 100%;
            }
            .header {
                padding: 5px 20px;
            }
            .logo img {
                width: 120px;
                height: 120px;
            }
            .company-name {
                font-size: 24px;
            }
            .company-subtitle {
                font-size: 14px;
            }
            .presupuesto-title h1 {
                font-size: 28px;
            }
            .presupuesto-title .numero {
                font-size: 20px;
            }
            .producto-section {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="presupuesto-container">
        {{-- Watermark --}}
        <div class="watermark">
            <img src="{{ asset('img/Logo Alucristales.png') }}" alt="Watermark">
        </div>

        {{-- Header --}}
        <div class="header">
            <div class="logo-section">
                <div class="logo">
                    <img src="{{ asset('img/Logo Alucristales blanco.png') }}" alt="Logo">
                </div>
                <div>
                    <div class="company-name">ALUCRISTALES</div>
                    <div class="company-subtitle">PALERMO</div>
                </div>
            </div>
            <div class="presupuesto-title">
                <h1>PRESUPUESTO</h1>
                <div class="numero">Nro {{ $presupuesto->numero }}</div>
                <div class="nota">Documento no v&aacute;lido como Factura</div>
            </div>
        </div>

        {{-- Info de contacto + Fecha --}}
        <div class="info-fecha-row">
            <div class="info-section">
                <div><strong>OFICINAS:</strong> {{ strtoupper($empresa->direccion ?? 'Araoz 2403 / Guemes 4888 / Palermo (CABA)') }}</div>
                <div><strong>TELEFONOS:</strong> {{ $empresa->telefono1 ?? '' }}{{ $empresa->telefono2 ? ' / ' . $empresa->telefono2 : '' }}</div>
                <div><strong>CORREO:</strong> {{ $empresa->email ?? '' }}</div>
            </div>
            <div class="fecha-box">
                FECHA:<br>{{ $presupuesto->fecha->format('d/m/Y') }}
            </div>
        </div>

        {{-- Información del cliente --}}
        <div class="cliente-info">
            <h3>INFORMACION DEL CLIENTE:</h3>
            <table>
                <tr>
                    <td>NOMBRE:</td>
                    <td>{{ $presupuesto->cliente_nombre ?? '' }}</td>
                    <td style="border:none; width: 100px;"></td>
                </tr>
                <tr>
                    <td>DIRECCION:</td>
                    <td>{{ $presupuesto->cliente_direccion ?? '' }}</td>
                    <td style="border:none;"></td>
                </tr>
                <tr>
                    <td>TELEFONO:</td>
                    <td>{{ $presupuesto->cliente_telefono ?? '' }}</td>
                    <td style="border:none; font-weight: bold;">FAX: {{ $presupuesto->cliente_fax ?? '' }}</td>
                </tr>
                <tr>
                    <td>EMAIL:</td>
                    <td>{{ $presupuesto->cliente_email ?? '' }}</td>
                    <td style="border:none;"></td>
                </tr>
            </table>
        </div>

        {{-- Items del presupuesto --}}
        @foreach($presupuesto->items as $item)
        <div class="producto-section">
            <div class="producto-imagen">
                @php
                    $modeloKey = mb_strtolower(trim($item->modelo ?? ''));
                    $tipoKey = mb_strtolower(trim($item->tipo_producto ?? ''));
                    $imagenPath = $productoImagenes[$modeloKey] ?? $productoImagenes[$tipoKey] ?? null;
                @endphp
                @if($imagenPath)
                    <img src="{{ asset($imagenPath) }}" alt="{{ $item->modelo ?? $item->tipo_producto }}"
                         style="max-width: 180px; max-height: 180px; object-fit: contain;">
                @else
                    <div class="ventana-preview"></div>
                @endif
            </div>

            <div class="detalles-precio">
                <h3>DETALLES Y PRECIO</h3>
                <div class="detalle-item"><strong>Tipo:</strong> {{ strtoupper($item->tipo_producto ?? 'N/A') }}</div>
                <div class="detalle-item"><strong>Opci&oacute;n:</strong> {{ $item->modelo ?? 'N/A' }}</div>
                <div class="detalle-item"><strong>Color de Aluminio:</strong> {{ $item->color_aluminio ?? 'N/A' }}</div>
                <div class="detalle-item"><strong>Altura:</strong> {{ $item->alto ?? '-' }} <strong>Ancho:</strong> {{ $item->ancho ?? '-' }}</div>
                <div class="detalle-item"><strong>Detalle:</strong> {{ $item->descripcion ?? 'N/A' }}</div>
                <div class="detalle-item"><strong>Precio:</strong> {{ number_format($item->precio_unitario, 0, ',', '.') }} <strong>Cantidad:</strong> {{ $item->cantidad }}</div>
                <div class="detalle-item"><strong>Descuento:</strong> {{ $item->descuento_porcentaje ?? 0 }}</div>
                <div class="detalle-item"><strong>Total:</strong> {{ number_format($item->total, 0, ',', '.') }}</div>
            </div>

            <div class="especificaciones">
                <h3>ESPECIFICACIONES</h3>
                <div class="detalle-item"><strong>Premarco:</strong> {{ $item->premarco ?? 'N/A' }}</div>
                <div class="detalle-item"><strong>Tapajuntas:</strong> {{ $item->tapajuntas ?? 'N/A' }}</div>
                <div class="detalle-item"><strong>Angulo:</strong> {{ $item->angulo ?? 'N/A' }}</div>
                <div class="detalle-item"><strong>Linea:</strong> {{ $item->linea ?? 'N/A' }}</div>
                <div class="detalle-item"><strong>Opcional:</strong> N/A</div>
            </div>
        </div>
        @endforeach

        {{-- Observación --}}
        <div class="observacion">
            <h4>OBSERVACION:</h4>
            <p>{{ $presupuesto->observacion ?? 'INCLUYE INSTALACION, PRECIO SIN IVA, MEDIDAS APROXIMADAS' }}</p>
            <p class="cliente-nota">Sr. Cliente:<br>
            El Presupuesto es v&aacute;lido por 15 d&iacute;as m&aacute;ximo y 10 d&iacute;as m&iacute;nimo.<br>
            Consultar en administraci&oacute;n los d&iacute;as de fabricaci&oacute;n y los m&eacute;todos de pago.</p>
        </div>

        {{-- Totales --}}
        <div class="totales">
            <table>
                <tr>
                    <td>SubTotal:</td>
                    <td>$ {{ number_format($presupuesto->subtotal, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>I.V.A. {{ number_format($presupuesto->iva_porcentaje, 0) }}%:</td>
                    <td>
                        @if($presupuesto->aplica_iva)
                            $ {{ number_format($presupuesto->iva_monto, 0, ',', '.') }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Total:</td>
                    <td>$ {{ number_format($presupuesto->total, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>