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
                <!-- Ventas -->
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

                <!-- Usuarios -->
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

                <!-- Productos -->
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

                <!-- Ingresos -->
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

            <!-- Segunda fila -->
            <div class="row">
                <!-- Producto más vendido -->
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

                <!-- Stock bajo -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-danger text-white">
                            <i class="bi bi-exclamation-triangle"></i>
                            Stock bajo
                        </div>

                        <div class="card-body">
                            @forelse($productosStockBajo ?? [] as $producto)
                                <p class="mb-1">
                                    {{ $producto->nombre }}

                                    <span class="badge bg-danger">
                                        {{ $producto->stock }}
                                    </span>
                                </p>
                            @empty
                                <p class="text-muted">
                                    Todos los productos tienen stock suficiente
                                </p>
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