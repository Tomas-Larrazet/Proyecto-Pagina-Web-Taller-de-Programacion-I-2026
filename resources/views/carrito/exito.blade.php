@extends('layouts.app')

@section('titulo', '¡Compra Exitosa! - Brightness.Store')

@section('contenido')
<div class="container my-5 py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            
            <div class="mb-4">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
            </div>
            
            <h1 class="fw-bold text-dark mb-2">¡Gracias por tu compra!</h1>
            <p class="text-muted fs-5 mb-5">Tu pedido ha sido procesado con éxito. Ya estamos preparando tus accesorios.</p>
            <p class="text-muted fs-5 mb-5">Nos comunicaremos a tu correo para enviarte informacion sobre el envio ;)</p>
            
            <div class="card border-0 shadow-sm rounded-4 bg-white text-start mb-4 p-4">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                    <span class="fw-bold text-muted uppercase small" style="letter-spacing: 1px;">Resumen del Pedido</span>
                    <span class="badge bg-dark px-3 py-2 rounded-pill">Pedido #{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>

                <div class="mb-3">
                    @foreach($pedido->detalles as $detalle)
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-light">
                            <div>
                                <span class="fw-bold text-dark">{{ $detalle->producto->nombre }}</span>
                                <small class="text-muted d-block">Cantidad: {{ $detalle->cantidad }}</small>
                            </div>
                            <span class="fw-bold text-muted">${{ number_format($detalle->precio_unitario * $detalle->cantidad, 2, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-between align-items-center pt-2">
                    <h4 class="fw-bold m-0 text-dark">Total Abonado</h4>
                    <h3 class="text-success fw-bold m-0">${{ number_format($pedido->total, 2, ',', '.') }}</h3>
                </div>
            </div>

            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 mt-4">
                <a href="{{ route('pedidos.factura', $pedido->id) }}" class="btn btn-dark btn-lg fw-bold px-4 py-3 rounded-pill shadow-sm">
                    <i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i> Descargar Comprobante PDF
                </a>
                
                <a href="{{ route('catalogo.index') }}" class="btn btn-warning btn-lg fw-bold px-4 py-3 rounded-pill shadow-sm" style="background-color: rgb(248, 233, 69);">
                    <i class="bi bi-arrow-left me-2"></i> Volver al Catálogo
                </a>
            </div>

            <div class="mt-5">
                <a href="{{ url('/mis-compras') }}" class="text-muted fw-bold small text-decoration-none border-bottom">
                    Ver mi historial de compras 
                </a>
            </div>

        </div>
    </div>
</div>
@endsection