@extends('admin.panel') 

@section('titulo', 'PanelPrincipal - Brightness.Store')

@section('contenido')

<div class="container-fluid">
<div class="row">
    <div class="col-12">
        <div class="container mt-5 border-bottom pb-4">
            <h2 class="mb-4">Resumen General</h2>
            
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
            <h2 class="mb-4">Estadisticas del emprendimiento</h2>
        </div>
    </div>
</div>
</div>

@endsection