<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Panel de Administración - Brightness.Store')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}" target="_blank">💎 Brightness.Store | Ver Tienda Pública</a>

            <div class="d-flex">
                <a href="{{ route('admin.panel-principal') }}" class="btn btn-outline-light btn-sm me-2">Panel de Control</a>
            </div>

            <div class="d-flex">
                <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-light btn-sm me-2">Ir a Productos</a>
            </div>
            
            <div class="d-flex">
                <a href="{{ route('admin.ventas.index') }}" class="btn btn-outline-light btn-sm me-2">Ver Ventas</a>
            </div>

            <div class="d-flex">
                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-light btn-sm me-2">Ver Usuarios Registrados</a>
            </div>

            <div class="d-flex">
                <a href="{{ route('admin.consultas.index') }}" class="btn btn-outline-light btn-sm me-2">Bandeja de Mensajes</a>
            </div>

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

    <main class="flex-grow-1">
     @yield('contenido')
    </main>

</body>
</html>