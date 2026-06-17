@extends('admin.panel') 

@section('titulo', 'Mis Productos - Brightness.Store')

@section('contenido')

<div class="container mt-3 mt-md-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <h2 class="h4 h-sm-2 mb-0">Gestión de Productos</h2>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.panel-principal') }}" class="btn btn-secondary btn-sm">Volver al Panel</a>
            <a href="{{ route('admin.categorias.create') }}" class="btn btn-outline-warning text-dark fw-bold btn-sm">+ Nueva Categoría</a>
            <a href="{{ route('admin.productos.create') }}" class="btn btn-success btn-sm">+ Nuevo Producto</a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="d-none d-lg-table-cell">ID</th>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th class="d-none d-md-table-cell">Precio</th>
                            <th class="d-none d-md-table-cell">Stock</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productos as $producto)
                            <tr>
                                <td class="d-none d-lg-table-cell">{{ $producto->id }}</td>
                                <td>
                                    @if($producto->url_imagen)
                                        <img src="{{ asset( $producto->url_imagen) }}" alt="Foto" width="50" class="img-thumbnail">
                                    @else
                                        <span class="text-muted small">Sin foto</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $producto->nombre }}
                                    <div class="d-md-none text-muted small mt-1">
                                        ${{ number_format($producto->precio, 2) }} · Stock: {{ $producto->stock }}
                                    </div>
                                </td>
                                <td class="d-none d-md-table-cell text-nowrap">${{ number_format($producto->precio, 2) }}</td>
                                <td class="d-none d-md-table-cell">{{ $producto->stock }}</td>
                                <td>
                                    <div class="d-flex gap-1 flex-wrap">
                                        <a href="{{ route('admin.productos.edit', $producto->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                        <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de dar de baja este producto?')">Borrar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No hay productos cargados todavía.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection