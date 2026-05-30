@extends('layouts.app') 

@section('titulo', 'Mis Compras - Brightness.Store')

@section('contenido')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-dark border-bottom border-dark pb-3">
                <i class="bi bi-bag-check-fill text-warning me-2"></i>Mis Compras
            </h2>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($pedidos->isEmpty())
        <div class="text-center py-5 shadow-sm rounded-4 bg-white border border-light mt-4">
            <i class="bi bi-box-seam text-muted mb-3 d-block" style="font-size: 5rem;"></i>
            <h3 class="fw-bold text-secondary">Aún no tienes compras</h3>
            <p class="text-muted mb-4">¡Tu historial está vacío! Descubrí nuestros accesorios y hacé tu primer pedido.</p>
            <a href="{{ route('catalogo.index') }}" class="btn btn-dark fw-bold px-4 py-2 shadow-sm rounded-pill">
                Ir al Catálogo
            </a>
        </div>
    @else
        <div class="row g-4">
            @foreach($pedidos as $pedido)
                <div class="col-12">
                    <div class="card shadow-sm border-bottom border-dark rounded-4 overflow-hidden">
                        
                        <div class="card-header bg-light border-bottom-0 py-3 px-4 d-flex flex-wrap justify-content-between align-items-center">
                            <div>
                                <span class="text-muted small d-block">Pedido realizado el</span>
                                <span class="fw-bold text-dark">{{ $pedido->created_at->format('d de M, Y - H:i') }}</span>
                            </div>
                            <div class="text-center mt-2 mt-md-0">
                                <span class="text-muted small d-block">Total de la compra</span>
                                <span class="fw-bold text-success fs-5">${{ number_format($pedido->total, 2, ',', '.') }}</span>
                            </div>
                            <div class="text-end mt-2 mt-md-0">
                                <span class="text-muted small d-block">N° de Pedido</span>
                                <span class="badge bg-dark fs-6 px-3">#{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @foreach($pedido->detalles as $detalle)
                                    <li class="list-group-item p-4 d-flex align-items-center">
                                        
                                        @if($detalle->producto)
                                            <img src="{{ asset($detalle->producto->url_imagen) }}" alt="{{ $detalle->producto->nombre }}" class="rounded shadow-sm border" style="width: 70px; height: 70px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary rounded shadow-sm border d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                                <i class="bi bi-image text-white fs-4"></i>
                                            </div>
                                        @endif

                                        <div class="ms-4 flex-grow-1">
                                            <h6 class="fw-bold mb-1 text-dark">
                                                {{ $detalle->producto ? $detalle->producto->nombre : 'Producto no disponible' }}
                                            </h6>
                                            <p class="mb-0 text-muted small">
                                                Precio unitario: ${{ number_format($detalle->precio_unitario, 2, ',', '.') }}
                                            </p>
                                        </div>

                                        <div class="ms-3 text-end">
                                            <span class="badge bg-light text-dark border px-3 py-2 rounded-3 fs-6 mb-1">
                                                x{{ $detalle->cantidad }} u.
                                            </span>
                                            <p class="mb-0 fw-bold text-dark">
                                                ${{ number_format($detalle->precio_unitario * $detalle->cantidad, 2, ',', '.') }}
                                            </p>
                                        </div>

                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <div class="card-footer bg-white border-top py-3 px-4 text-end">
                            <span class="text-muted fw-bold me-2">Estado:</span>
                            @if(strtolower($pedido->estado) == 'pendiente')
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill"><i class="bi bi-clock-history me-1"></i> Pendiente</span>
                            @elseif(strtolower($pedido->estado) == 'pagado')
                                <span class="badge bg-success px-3 py-2 rounded-pill"><i class="bi bi-check2-circle me-1"></i> Pagado</span>
                            @else
                                <span class="badge bg-info text-dark px-3 py-2 rounded-pill"><i class="bi bi-box-seam me-1"></i> {{ ucfirst($pedido->estado) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection