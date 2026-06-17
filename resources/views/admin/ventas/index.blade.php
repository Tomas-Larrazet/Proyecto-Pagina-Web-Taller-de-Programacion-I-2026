@extends('admin.panel') 

@section('titulo', 'Ventas realizadas - Brightness.Store')

@section('contenido')

<div class="container mt-3 mt-md-5">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
        <h2 class="h4 h-sm-2 mb-0">Historial de Ventas</h2>
        <a href="{{ route('admin.panel-principal') }}" class="btn btn-secondary btn-sm">Volver al Panel</a>
    </div>

    <div class="card shadow-sm border-success">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Todos los pedidos</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>N° Pedido</th>
                            <th class="d-none d-md-table-cell">Fecha</th>
                            <th class="d-none d-md-table-cell">Cliente</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ventas as $venta)
                            <tr>
                                <td>
                                    #{{ str_pad($venta->id, 5, '0', STR_PAD_LEFT) }}
                                    <div class="d-md-none text-muted small mt-1">
                                        {{ $venta->created_at->format('d/m/Y H:i') }}<br>
                                        {{ $venta->user->email ?? 'Usuario dado de baja' }}
                                    </div>
                                </td>
                                <td class="d-none d-md-table-cell text-nowrap">{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                                <td class="d-none d-md-table-cell">{{ $venta->user->email ?? 'Usuario dado de baja' }}</td>
                                <td class="fw-bold text-nowrap">${{ number_format($venta->total, 2, ',', '.') }}</td>
                                <td>
                                    @php
                                        $colorEstado = match($venta->estado) {
                                            'cancelado' => 'danger',
                                            'pagado' => 'warning',
                                            'pendiente' => 'warning',
                                            'enviado' => 'primary',
                                            'entregado' => 'success',
                                            default => 'secondary'
                                        };
                                    @endphp

                                    <span class="badge bg-{{ $colorEstado }}">
                                        {{ ucfirst($venta->estado ?? 'Pendiente') }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.ventas.show', $venta->id) }}" class="btn btn-sm btn-outline-success">Ver Detalle</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Todavía no hay ventas registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection