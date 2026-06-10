<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Productos - Brightness.Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
        <h2>Gestión de Productos</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.panel') }}" class="btn btn-secondary">Volver al Panel</a>
            <a href="{{ route('admin.categorias.create') }}" class="btn btn-outline-warning text-dark fw-bold">+ Nueva Categoría</a>
            <a href="{{ route('admin.productos.create') }}" class="btn btn-success">+ Nuevo Producto</a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productos as $producto)
                        <tr>
                            <td>{{ $producto->id }}</td>
                            <td>
                                @if($producto->url_imagen)
                                    <img src="{{ asset( $producto->url_imagen) }}" alt="Foto" width="50" class="img-thumbnail">
                                @else
                                    <span class="text-muted">Sin foto</span>
                                @endif
                            </td>
                            <td>{{ $producto->nombre }}</td>
                            <td>${{ number_format($producto->precio, 2) }}</td>
                            <td>{{ $producto->stock }}</td>
                            <td>
                                <a href="{{ route('admin.productos.edit', $producto->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de dar de baja este producto?')">Borrar</button>
                                </form>
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

</body>
</html>