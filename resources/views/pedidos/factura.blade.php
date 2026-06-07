<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Compra - Brightness</title>
    <style>
        body { font-family: Helvetica, Arial, sans-serif; color: #333; font-size: 14px; }
        .encabezado { border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; text-align: center; }
        .logo { font-size: 24px; font-weight: bold; letter-spacing: 4px; margin-bottom: 5px; }
        .datos-cliente { margin-bottom: 30px; }
        .datos-cliente p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border-bottom: 1px solid #ddd; padding: 12px 8px; text-align: left; }
        th { background-color: #f8f9fa; font-weight: bold; text-transform: uppercase; font-size: 12px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-container { text-align: right; margin-top: 30px; font-size: 18px; font-weight: bold; }
        .footer { text-align: center; margin-top: 50px; font-size: 12px; color: #777; border-top: 1px solid #ddd; padding-top: 20px; }
    </style>
</head>
<body>

    <div class="encabezado">
        <div class="logo">B R I G H T N E S S</div>
        <p style="margin: 0; color: #666;">Comprobante de Compra #{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}</p>
    </div>

    <div class="datos-cliente">
        <p><strong>Cliente:</strong> {{ $pedido->user->name }}</p>
        <p><strong>Fecha de compra:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Estado:</strong> Pagado / Aprobado</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th class="text-center">Cant.</th>
                <th class="text-right">Precio Un.</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedido->detalles as $detalle)
            <tr>
                <td>{{ $detalle->producto->nombre }}</td>
                <td class="text-center">{{ $detalle->cantidad }}</td>
                <td class="text-right">${{ number_format($detalle->precio_unitario, 2, ',', '.') }}</td>
                <td class="text-right">${{ number_format($detalle->cantidad * $detalle->precio_unitario, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-container">
        Total Abonado: ${{ number_format($pedido->total, 2, ',', '.') }}
    </div>

    <div class="footer">
        ¡Gracias por elegir Brightness Store!<br>
        Este documento es un comprobante de pago no válido como factura fiscal.
    </div>

</body>
</html>