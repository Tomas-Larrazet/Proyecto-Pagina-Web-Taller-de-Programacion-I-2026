@extends('layouts.app')

@section('titulo', 'Carrito - Brightness.Store')

@section('contenido')
<div class="container my-5">
    <h1 class="mb-4 fw-bold text-dark"><i class="bi bi-cart4 text-warning me-2"></i>Tu Carrito de Compras</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(empty($carrito))
        <div class="text-center py-5 shadow-sm rounded-4 bg-white border border-light">
            <i class="bi bi-bag-x text-muted mb-3 d-block" style="font-size: 5rem;"></i>
            <h3 class="fw-bold text-secondary">Tu carrito está vacío</h3>
            <p class="text-muted mb-4 px-3">¿Aún no sabés qué llevar? Explora nuestro catálogo y encontrá los mejores accesorios de Brightness.</p>
            <a href="{{ route('catalogo.index') }}" class="btn btn-warning fw-bold px-4 py-2 shadow-sm rounded-pill">
                <i class="bi bi-arrow-left me-1"></i> Ir al Catálogo
            </a>
        </div>
    @else
        <div class="row g-4">
            
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <thead>
                                <tr class="text-muted border-bottom small fw-bold text-uppercase" style="letter-spacing: 0.5px;">
                                    <th scope="col" colspan="2">Producto</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col" class="text-center">Cantidad</th>
                                    <th scope="col">Subtotal</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($carrito as $id => $item)
                                    <tr class="border-bottom">
                                        <td style="width: 80px;" class="py-3">
                                            <img src="{{ asset($item['url_imagen']) }}" alt="{{ $item['nombre'] }}" 
                                                 class="img-fluid rounded-3 border" style="object-fit: cover; height: 65px; width: 65px;">
                                        </td>
                                        <td class="py-3">
                                            <h6 class="fw-bold mb-0 text-dark">{{ $item['nombre'] }}</h6>
                                        </td>
                                        <td class="py-3 text-muted">
                                            ${{ number_format($item['precio'], 2, ',', '.') }}
                                        </td>
                                        <td class="py-3 text-center fw-bold text-dark">
                                            <span class="badge bg-light text-dark border px-3 py-2 rounded-3 fs-6">
                                                {{ $item['cantidad'] }}
                                            </span>
                                        </td>
                                        <td class="py-3 fw-bold text-dark">
                                            ${{ number_format($item['precio'] * $item['cantidad'], 2, ',', '.') }}
                                        </td>
                                        <td class="py-3 text-end">
                                            <form action="{{ route('carrito.eliminar', $id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-link text-danger p-0 border-0" title="Eliminar del carrito">
                                                    <i class="bi bi-trash3 fs-5"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-4 gap-3">
                        <a href="{{ route('catalogo.index') }}" class="text-decoration-none fw-bold text-dark small">
                            <i class="bi bi-arrow-left me-1"></i> Continuar comprando
                        </a>
                        
                        <form action="{{ route('carrito.vaciar') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm fw-bold px-3 py-2 rounded-3">
                                <i class="bi bi-trash3-fill me-1"></i> Vaciar Carrito
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-4 rounded-4 bg-white position-sticky" style="top: 20px;">
                    <h5 class="fw-bold text-dark mb-4">Resumen del Pedido</h5>
                    
                    <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                        <span class="text-muted">Total Productos</span>
                        <span class="fw-bold text-dark">
                            {{ array_sum(array_column($carrito, 'cantidad')) }} unidades
                        </span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                        <span class="text-muted">Envío</span>
                        <span class="text-success fw-bold small">¡Gratis!</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="h5 fw-bold text-dark mb-0">Total Final</span>
                        <span class="h4 fw-bold text-success mb-0">
                            ${{ number_format($total, 2, ',', '.') }}
                        </span>
                    </div>

                    @if(auth()->user()->rol == 'admin') <button type="button" class="btn btn-secondary w-100 fw-bold py-3 shadow-sm rounded-3 text-uppercase" style="letter-spacing: 0.5px;" disabled>
                            <i class="bi bi-ban me-1 fs-5 align-middle"></i> Los administradores no pueden comprar
                        </button>
                    @else
                        <form action="{{ route('carrito.comprar') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning w-100 fw-bold py-3 shadow-sm rounded-3 btn-confirmar-compra text-uppercase" style="letter-spacing: 0.5px;">
                                <i class="bi bi-bag-check-fill me-1 fs-5 align-middle"></i> Confirmar Compra
                            </button>
                        </form>
                    @endif

                    <div class="text-center mt-3">
                        <span class="text-muted small"><i class="bi bi-shield-lock-fill text-muted me-1"></i> Pago 100% Seguro</span>
                    </div>
                </div>
            </div>

        </div>
    @endif
</div>

@endsection