@extends('admin.panel') 

@section('titulo', 'Consultas y Contacto - Brightness.Store')

@section('contenido')

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Bandeja de Consultas</h2>
        <a href="{{ route('admin.panel-principal') }}" class="btn btn-secondary">Volver al Panel</a>
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

@endsection