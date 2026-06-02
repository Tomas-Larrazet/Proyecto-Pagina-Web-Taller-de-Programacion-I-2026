<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Brightness.Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}" target="_blank">💎 Brightness.Store | Ver Tienda Pública</a>
            <div class="d-flex">
                <span class="navbar-text me-3">
                    Hola, {{ Auth::user()->name }}
                </span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Salir</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4">Resumen General</h2>
        
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-primary">
                    <div class="card-body text-center">
                        <h5 class="card-title text-primary">Gestión de Productos</h5>
                        <p class="card-text">Alta, baja y modificación de joyas.</p>
                        <a href="{{ route('admin.productos.index') }}" class="btn btn-primary">Ir a Productos</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-success">
                    <div class="card-body text-center">
                        <h5 class="card-title text-success">Ventas Realizadas</h5>
                        <p class="card-text">Revisá el historial de compras.</p>
                        <a href="{{ route('admin.ventas.index') }}" class="btn btn-success">Ver Ventas</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-warning">
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

</body>
</html>