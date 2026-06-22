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

    @if(empty($carrito) || count($carrito) == 0)
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
                            <th scope="col" class="text-center">Subtotal</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($carrito as $item)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset($item->producto->url_imagen ?? 'images/default.jpg') }}" alt="{{ $item->producto->nombre }}" class="rounded shadow-sm me-3" style="width: 70px; height: 70px; object-fit: cover;">
                                        <span class="fw-bold text-dark" style="max-width: 200px;">{{ $item->producto->nombre }}</span>
                                    </div>
                                </td>
                                
                                <td class="text-center text-muted">
                                    ${{ number_format($item->producto->precio, 2, ',', '.') }}
                                </td>
                                
                                <td class="py-3 text-center">
                                    <form action="{{ url('/carrito/actualizar-cantidad/' . $item->producto_id) }}" method="POST" class="d-flex justify-content-center align-items-center gap-2">
                                        @csrf
                                        <input 
                                            type="number" 
                                            name="cantidad" 
                                            value="{{ $item->cantidad }}" 
                                            min="1" 
                                            max="{{ $item->producto->stock }}"
                                            class="form-control form-control-sm text-center" 
                                            style="width: 70px;"
                                            onchange="this.form.submit()"
                                        >
                                        <button type="submit" class="btn btn-sm btn-outline-dark" title="Actualizar cantidad">
                                            <i class="bi bi-check2"></i>
                                        </button>
                                    </form>
                                    @if($item->cantidad >= $item->producto->stock)
                                        <div class="small text-danger mt-1">Stock máximo alcanzado</div>
                                    @endif
                                </td>
                                
                                <td class="text-center fw-bold text-dark">
                                    ${{ number_format($item->producto->precio * $item->cantidad, 2, ',', '.') }}
                                </td>
                                
                                <td class="text-center pe-4">
                                    <form action="{{ url('/carrito/eliminar/' . $item->producto_id) }}" method="POST" class="m-0" onsubmit="return confirm('¿Quitar este producto del carrito?');">
                                        @csrf
                                        <button type="submit" class="btn btn-link text-danger p-0" title="Eliminar producto">
                                            <i class="bi bi-trash fs-5"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 bg-light">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-4">Resumen del Pedido</h4>
                
                <div class="d-flex justify-content-between mb-2 text-muted">
                    <span>Subtotal ({{ $carrito->sum('cantidad') }} un.)</span>
                    <span class="fw-bold text-dark">${{ number_format($subtotal, 2, ',', '.') }}</span>
                </div>
                
                <div class="d-flex justify-content-between mb-3 text-muted">
                    <span>Envío</span>
                    <span class="text-success fw-bold">¡Gratis!</span>
                </div>

                @if($porcentajeDescuento > 0)
                    <div class="d-flex justify-content-between mb-3 text-success fw-bold">
                        <span>Descuento ({{ $porcentajeDescuento }}%)</span>
                        <span>- ${{ number_format($montoDescuento, 2, ',', '.') }}</span>
                    </div>
                @endif
                
                <hr>
                
                <div class="d-flex justify-content-between mb-4">
                    <h4 class="fw-bold m-0 text-dark">Total Final</h4>
                    <h4 class="text-success fw-bold m-0">${{ number_format($total, 2, ',', '.') }}</h4>
                </div>

                <div class="mb-4 p-3 bg-white rounded shadow-sm border">
                    <label class="form-label fw-bold small text-dark mb-2">¿Tenés un código de descuento?</label>
                    <form action="{{ route('carrito.cupon') }}" method="POST" class="d-flex gap-2">
                        @csrf
                        <input type="text" name="codigo_cupon" class="form-control border-warning" placeholder="Ej: BRIGHTNESS" required {{ $porcentajeDescuento > 0 ? 'disabled' : '' }}>
                        <button type="submit" class="btn btn-dark fw-bold px-3" {{ $porcentajeDescuento > 0 ? 'disabled' : '' }}>Aplicar</button>
                    </form>
                    @if($porcentajeDescuento > 0)
                        <small class="text-success fw-bold mt-2 d-block"><i class="bi bi-check-circle-fill"></i> ¡Cupón aplicado!</small>
                    @endif
                </div>
                
                <form action="{{ url('/carrito/comprar') }}" method="POST" class="d-grid">
                    @csrf
                    <input type="hidden" name="total_esperado" value="{{ $total }}">
                    <button type="submit" class="btn btn-warning btn-lg fw-bold rounded-pill shadow-sm" style="background-color: rgb(248, 233, 69);">
                        Confirmar Compra
                    </button>
                </form>

                <div class="text-center mt-4">
                    <span class="text-muted small fw-bold">
                        <i class="bi bi-shield-lock-fill text-warning me-1 fs-5 align-middle"></i> Pago 100% Seguro
                    </span>
                </div>
            </div>
        </div>
    </div>

</div>
        @endif
     </div>
@endsection