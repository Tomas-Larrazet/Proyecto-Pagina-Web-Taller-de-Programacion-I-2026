@extends('admin.panel') 

@section('titulo', 'PanelPrincipal - Brightness.Store')

@section('contenido')

<div class="container-fluid">
<div class="row">
    <div class="col-12">
        <div class="container mt-5 border-bottom pb-4">
            <h2 class="mb-4"><i class="bi bi-book"></i> Resumen General</h2>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-primary h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary">Gestión de Productos</h5>
                            <p class="card-text">Alta, baja y modificación de joyas.</p>
                            <a href="{{ route('admin.productos.index') }}" class="btn btn-primary">Ir a Productos</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-success h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title text-success">Ventas Realizadas</h5>
                            <p class="card-text">Revisá el historial de compras.</p>
                            <a href="{{ route('admin.ventas.index') }}" class="btn btn-success">Ver Ventas</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-warning h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title text-warning">Usuarios y Consultas</h5>
                            <p class="card-text">Administrá clientes y mensajes.</p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-warning text-dark fw-bold">Ver Usuarios Registrados</a>
                                <a href="{{ route('admin.consultas.index') }}" class="btn btn-warning">Bandeja de Mensajes</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
        </div>
    </div>

    <div class="col-12">
        <div class="container mt-5 border-bottom pb-4">
            <h2 class="mb-4">
                <i class="bi bi-bar-chart-line"></i>
                Estadísticas del emprendimiento
            </h2>


            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm border-success h-100">
                        <div class="card-body text-center">

                            <i class="bi bi-cart-check-fill fs-1 text-success"></i>

                            <h5 class="mt-3">
                                Ventas realizadas
                            </h5>

                            <h2 class="fw-bold">
                                {{ $totalVentas ?? 0 }}
                            </h2>

                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm border-primary h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-people-fill fs-1 text-primary"></i>

                            <h5 class="mt-3">
                                Usuarios registrados
                            </h5>

                            <h2 class="fw-bold">
                                {{ $totalUsuarios ?? 0 }}
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm border-warning h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-gem fs-1 text-warning"></i>

                            <h5 class="mt-3">
                                Productos activos
                            </h5>

                            <h2 class="fw-bold">
                                {{ $totalProductos ?? 0 }}
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm border-danger h-100">
                        <div class="card-body text-center">

                            <i class="bi bi-currency-dollar fs-1 text-danger"></i>

                            <h5 class="mt-3">
                                Ingresos
                            </h5>

                            <h2 class="fw-bold">
                                ${{ number_format($ingresos ?? 0,0,',','.') }}
                            </h2>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">
                                🏆 Top 5 productos más vendidos
                            </h5>
                        </div>

                        <div class="card-body">
                            <ol class="list-group list-group-numbered">
                            @forelse($topProductos as $producto)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        {{ $producto->producto->nombre ?? 'Producto eliminado' }}
                                    </span>

                                    <span class="badge bg-success rounded-pill">
                                        {{ $producto->total_vendido }} vendidos
                                    </span>
                                </li>
                            @empty
                                <p class="text-muted text-center">
                                    Todavía no hay ventas registradas.
                                </p>
                            @endforelse
                            </ol>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-danger text-white fw-bold d-flex align-items-center justify-content-between">
                            <span><i class="bi bi-exclamation-triangle-fill me-2"></i>Alerta de Stock Bajo</span>
                            <span class="badge bg-white text-danger">{{ count($productosStockBajo ?? []) }}</span>
                        </div>

                        <div class="card-body p-0">
                            @forelse($productosStockBajo ?? [] as $producto)
                                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                                    <span class="fw-semibold text-dark">{{ $producto->nombre }}</span>
                                    <div>
                                        <span class="badge bg-danger px-2 py-1.5" title="Stock actual">
                                            {{ $producto->stock }} u.
                                        </span>
                                        <span class="text-muted small ms-2" style="font-size: 0.8rem;">
                                            (Mín: {{ $producto->stock_minimo }})
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <i class="bi bi-shield-check text-success fs-2 d-block mb-1"></i>
                                    <p class="text-muted mb-0">Todos los productos tienen stock suficiente</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@endsection