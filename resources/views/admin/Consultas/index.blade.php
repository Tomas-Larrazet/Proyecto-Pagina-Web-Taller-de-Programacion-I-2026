<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas y Contacto - Brightness.Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Bandeja de Consultas</h2>
        <a href="{{ route('admin.panel') }}" class="btn btn-secondary">Volver al Panel</a>
    </div>

    <div class="card shadow-sm border-warning">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">Mensajes Recibidos</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Remitente</th>
                        <th>Email</th>
                        <th>Tipo de Usuario</th>
                        <th>Mensaje</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($consultas as $consulta)
                        <tr>
                            <td class="text-nowrap">{{ $consulta->created_at->format('d/m/Y H:i') }}</td>
                            <td class="fw-bold">{{ $consulta->nombre }}</td>
                            <td><a href="mailto:{{ $consulta->email }}">{{ $consulta->email }}</a></td>
                            <td>
                                @if($consulta->user_id)
                                    <span class="badge bg-success">Registrado (ID: {{ $consulta->user_id }})</span>
                                @else
                                    <span class="badge bg-secondary">Visitante</span>
                                @endif
                            </td>
                            <td>
                                {{ $consulta->mensaje ?? $consulta->consulta }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No hay mensajes en la bandeja de entrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>