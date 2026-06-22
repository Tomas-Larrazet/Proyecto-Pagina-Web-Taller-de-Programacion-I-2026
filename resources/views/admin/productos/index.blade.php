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

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.productos.index') }}" method="GET" class="row g-3 align-items-end">

                <div class="col-md-4">
                    <label class="form-label small fw-bold">Buscar producto</label>
                    <input type="text" name="buscar" class="form-control form-control-sm" placeholder="Nombre del producto" value="{{ request('buscar') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label small fw-bold">Categoría</label>
                    <select name="categoria" class="form-select form-select-sm">
                        <option value="">Todas</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ request('categoria') == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label small fw-bold">Stock</label>
                    <select name="stock" class="form-select form-select-sm">
                        <option value="">Todos</option>
                        <option value="bajo" {{ request('stock') == 'bajo' ? 'selected' : '' }}>Stock bajo (Segun producto)</option>
                        <option value="sin_stock" {{ request('stock') == 'sin_stock' ? 'selected' : '' }}>Sin stock (0)</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-success btn-sm w-100">
                        <i class="bi bi-funnel-fill"></i> Filtrar
                    </button>
                </div>

                @if(request('buscar') || request('categoria') || request('stock'))
                    <div class="col-12">
                        <a href="{{ route('admin.productos.index') }}" class="text-danger small fw-bold text-decoration-none">
                            <i class="bi bi-x-circle"></i> Limpiar filtros
                        </a>
                    </div>
                @endif
            </form>
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
                            <th class="d-none d-md-table-cell">Stock / Mínimo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productos as $producto)
                            <tr class="{{ $producto->stock <= $producto->stock_minimo ? 'table-warning' : '' }}">
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
                                        <span class="text-secondary">(Mín: {{ $producto->stock_minimo }})</span>
                                    </div>
                                </td>
                                <td class="d-none d-md-table-cell text-nowrap">${{ number_format($producto->precio, 2) }}</td>

                                <td class="d-none d-md-table-cell">
                                    <span class="fw-bold">{{ $producto->stock }} u.</span>
                                    @if($producto->stock == 0)
                                        <span class="badge bg-danger ms-1">Sin stock</span>
                                    @elseif($producto->stock <= $producto->stock_minimo)
                                        <span class="badge bg-warning text-dark ms-1">Bajo</span>
                                    @endif

                                    <small class="text-muted d-block" style="font-size: 0.75rem;">Mínimo: {{ $producto->stock_minimo }}</small>
                                </td>
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
                                <td colspan="6" class="text-center py-4">No se encontraron productos con esos filtros.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection