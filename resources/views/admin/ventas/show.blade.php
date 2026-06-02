<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Pedido #{{ $pedido->id }} - Brightness.Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detalle del Pedido #{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}</h2>
        <a href="{{ route('admin.ventas.index') }}" class="btn btn-secondary">Volver a Ventas</a>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Información General</h5>
                </div>
                <div class="card-body">
                    <p><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Cliente ID:</strong> #{{ $pedido->user_id }}</p>
                    <p><strong>Estado:</strong> <span class="badge bg-warning text-dark">{{ ucfirst($pedido->estado ?? 'Pendiente') }}</span></p>
                    <hr>
                    <h4 class="text-success mb-0">Total: ${{ number_format($pedido->total, 2) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-3">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Productos en este pedido</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
                                <th>Precio Unitario</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $items = $pedido->detalles ?? $pedido->productos ?? [];
                            @endphp

                            @forelse($items as $item)
                                <tr>
                                    <td>{{ $item->nombre ?? $item->producto?->nombre ?? 'Producto ID: ' . ($item->producto_id ?? 'N/A') }}</td>
                                    <td>${{ number_format($item->precio ?? $item->pivot?->precio ?? 0, 2) }}</td>
                                    <td>{{ $item->cantidad ?? $item->pivot?->cantidad ?? 1 }} un.</td>
                                    <td class="fw-bold">${{ number_format(($item->precio ?? $item->pivot?->precio ?? 0) * ($item->cantidad ?? $item->pivot?->cantidad ?? 1), 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-muted">No se encontraron productos en este pedido.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>