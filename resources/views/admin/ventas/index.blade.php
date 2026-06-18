@extends('admin.panel') 

@section('titulo', 'Ventas realizadas - Brightness.Store')

@section('contenido')

<div class="container mt-3 mt-md-5">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
        <h2 class="h4 h-sm-2 mb-0">Historial de Ventas</h2>
        <a href="{{ route('admin.panel-principal') }}" class="btn btn-secondary btn-sm">Volver al Panel</a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.ventas.index') }}" method="GET" class="row g-3 align-items-end">
                
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Estado</label>
                    <select name="estado" class="form-select form-select-sm">
                        <option value="">Todos</option>
                        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="pagado" {{ request('estado') == 'pagado' ? 'selected' : '' }}>Pagado</option>
                        <option value="enviado" {{ request('estado') == 'enviado' ? 'selected' : '' }}>Enviado</option>
                        <option value="entregado" {{ request('estado') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                        <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label small fw-bold">Desde</label>
                    <input type="date" name="fecha_desde" class="form-control form-control-sm" value="{{ request('fecha_desde') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label small fw-bold">Hasta</label>
                    <input type="date" name="fecha_hasta" class="form-control form-control-sm" value="{{ request('fecha_hasta') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label small fw-bold">Monto mín.</label>
                    <input type="number" name="monto_min" class="form-control form-control-sm" placeholder="$0" value="{{ request('monto_min') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label small fw-bold">Monto máx.</label>
                    <input type="number" name="monto_max" class="form-control form-control-sm" placeholder="$999999" value="{{ request('monto_max') }}">
                </div>

                <div class="col-md-1 d-flex gap-2">
                    <button type="submit" class="btn btn-success btn-sm w-100">
                        <i class="bi bi-funnel-fill"></i>
                    </button>
                </div>

                

                @if(request('estado') || request('fecha_desde') || request('fecha_hasta') || request('monto_min') || request('monto_max'))
                    <div class="col-12">
                        <a href="{{ route('admin.ventas.index') }}" class="text-danger small fw-bold text-decoration-none">
                            <i class="bi bi-x-circle"></i> Limpiar filtros
                        </a>
                    </div>
                @endif
            </form>
        </div>
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
                                <td colspan="6" class="text-center py-4 text-muted">No se encontraron ventas con esos filtros.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection