@extends('admin.panel') 

@section('titulo', 'Consultas y Contacto - Brightness.Store')

@section('contenido')

<div class="container mt-3 mt-md-5">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
        <h2 class="h4 h-sm-2 mb-0">Bandeja de Consultas</h2>
        <a href="{{ route('admin.panel-principal') }}" class="btn btn-secondary btn-sm btn-sm-md">Volver al Panel</a>
    </div>

    <div class="card shadow-sm border-warning">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">Mensajes Recibidos</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Remitente</th>
                            <th>Email</th>
                            <th class="d-none d-md-table-cell">Tipo de Usuario</th>
                            <th>Mensaje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($consultas as $consulta)
                            <tr>
                                <td class="text-nowrap">{{ $consulta->created_at->format('d/m/Y H:i') }}</td>
                                <td class="fw-bold">
                                    {{ $consulta->nombre }}
                                    <div class="d-md-none mt-1">
                                        @if($consulta->user_id)
                                            <span class="badge bg-success">Registrado</span>
                                        @else
                                            <span class="badge bg-secondary">Visitante</span>
                                        @endif
                                    </div>
                                </td>
                                <td><a href="mailto:{{ $consulta->email }}" class="text-break">{{ $consulta->email }}</a></td>
                                <td class="d-none d-md-table-cell">
                                    @if($consulta->user_id)
                                        <span class="badge bg-success">Registrado (ID: {{ $consulta->user_id }})</span>
                                    @else
                                        <span class="badge bg-secondary">Visitante</span>
                                    @endif
                                </td>
                                <td style="min-width: 200px;">
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
</div>

@endsection