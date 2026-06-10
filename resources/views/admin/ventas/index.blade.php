@extends('admin.panel') 

@section('titulo', 'Ventas realizadas - Brightness.Store')

@section('contenido')

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Historial de Ventas</h2>
        <a href="{{ route('admin.panel-principal') }}" class="btn btn-secondary">Volver al Panel</a>
    </div>

    <div class="card shadow-sm border-success">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Todos los pedidos</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>N° Pedido</th>
                        <th>Fecha</th>
                        <th>Cliente </th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ventas as $venta)
                        <tr>s
                            <td>#{{ str_pad($venta->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $venta->user->email ?? 'Usuario dado de baja' }}</td>
                            <td class="fw-bold">${{ number_format($venta->total, 2, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-{{ $venta->estado == 'pendiente' ? 'warning' : ($venta->estado == 'completado' ? 'success' : 'secondary') }}">
                                    {{ ucfirst($venta->estado ?? 'Completado') }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.ventas.show', $venta->id) }}" class="btn btn-sm btn-outline-success">Ver Detalle</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Todavía no hay ventas registradas. ¡Pronto llegará la primera!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection