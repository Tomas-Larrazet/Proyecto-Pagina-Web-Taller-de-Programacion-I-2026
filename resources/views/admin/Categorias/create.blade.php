<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Categoría - Brightness.Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-warning">
                <div class="card-header bg-warning text-dark fw-bold">
                    <h5 class="mb-0">Crear Nueva Categoría</h5>
                </div>
                <div class="card-body p-4">
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.categorias.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Nombre de la Categoría</label>
                            <input type="text" name="nombre" class="form-control" placeholder="Ej: Anillos de Plata" required value="{{ old('nombre') }}">
                            <small class="text-muted">Este nombre aparecerá en el menú lateral del catálogo público.</small>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary text-decoration-none">Cancelar</a>
                            <button type="submit" class="btn btn-warning fw-bold shadow-sm">Guardar Categoría</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>