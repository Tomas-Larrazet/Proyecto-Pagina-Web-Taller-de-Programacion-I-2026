<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Panel de Administración - Brightness.Store')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-light bg-dark shadow-sm w-100">
        <div class="container justify-content-center">

            <button class="navbar-toggler mb-2 border-0 shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#menuNavegacion" aria-controls="menuNavegacion" aria-expanded="false" aria-label="Abrir menú">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-center w-100" id="menuNavegacion">

                <ul class="navbar-nav align-items-center text-center gap-3 gap-lg-4 m-0">
                    <li class="nav-item"><a class="navbar-brand text-light" href="{{ url('/') }}" target="_blank">💎 Brightness.Store | Ver Tienda Pública</a></li>
                    <li class="nav-item"><a href="{{ route('admin.panel-principal') }}" class="btn btn-outline-light btn-sm me-2">Panel de Control</a></li>
                    <li class="nav-item"><a href="{{ route('admin.productos.index') }}" class="btn btn-outline-light btn-sm me-2">Ir a Productos</a></li>
                    <li class="nav-item"><a href="{{ route('admin.ventas.index') }}" class="btn btn-outline-light btn-sm me-2">Ver Ventas</a></li>
                    <li class="nav-item"><a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-light btn-sm me-2">Ver Usuarios Registrados</a></li>
                    <li class="nav-item"><a href="{{ route('admin.consultas.index') }}" class="btn btn-outline-light btn-sm me-2">Bandeja de Mensajes</a></li>
                
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 p-0" href="#" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="rounded-circle bg-warning text-black d-flex align-items-center justify-content-center shadow-sm" style=" width: 40px; height: 40px;">
                                <i class="bi bi-person-fill fs-5"></i>
                            </div>
                            <span class="d-none d-lg-inline text-light fw-semibold">{{ auth()->user()->name }}</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow mt-2">
                            <li><a class="dropdown-item" href="/perfil"><i class="bi bi-gear text-muted"></i> Editar Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ url('/logOut') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1">
     @yield('contenido')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>