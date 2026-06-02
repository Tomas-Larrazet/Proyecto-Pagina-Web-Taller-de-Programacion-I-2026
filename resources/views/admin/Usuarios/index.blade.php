<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Registrados - Brightness.Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Usuarios</h2>
        <div>
            <a href="{{ route('admin.panel') }}" class="btn btn-secondary">Volver al Panel</a>
            <a href="{{ route('admin.usuarios.create_admin') }}" class="btn btn-success">+ Nuevo Admin</a>
        </div>
    </div>

    <div class="card shadow-sm border-warning">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">Clientes Registrados</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo Electrónico</th>
                        <th>Fecha de Registro</th>
                        <th>Rol</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $usuario)
                        <tr>
                            <td>#{{ $usuario->id }}</td>
                            <td class="fw-bold">{{ $usuario->name }}</td>
                            <td><a href="mailto:{{ $usuario->email }}" class="text-decoration-none">{{ $usuario->email }}</a></td>
                            <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if($usuario->rol === 'admin' || $usuario->is_admin)
                                    <span class="badge bg-danger">Administrador</span>
                                @else
                                    <span class="badge bg-primary">Cliente</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Aún no hay usuarios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>