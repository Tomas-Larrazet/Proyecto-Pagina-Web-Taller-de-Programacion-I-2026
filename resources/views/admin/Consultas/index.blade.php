@extends('admin.panel') 

@section('titulo', 'Consultas y Contacto - Brightness.Store')

@section('contenido')

<div class="container mt-3 mt-md-5">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
        <h2 class="h4 h-sm-2 mb-0">Bandeja de Consultas</h2>
        <a href="{{ route('admin.panel-principal') }}" class="btn btn-secondary btn-sm btn-sm-md">Volver al Panel</a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.consultas.index') }}" method="GET" class="row g-3 align-items-end">

                <div class="col-md-4">
                    <label class="form-label small fw-bold">Tipo de usuario</label>
                    <select name="tipo" class="form-select form-select-sm">
                        <option value="">Todos</option>
                        <option value="registrado" {{ request('tipo') == 'registrado' ? 'selected' : '' }}>Registrado</option>
                        <option value="visitante" {{ request('tipo') == 'visitante' ? 'selected' : '' }}>Visitante</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-warning btn-sm w-100 fw-bold">
                        <i class="bi bi-funnel-fill"></i> Filtrar
                    </button>
                </div>

                @if(request('tipo'))
                    <div class="col-12">
                        <a href="{{ route('admin.consultas.index') }}" class="text-danger small fw-bold text-decoration-none">
                            <i class="bi bi-x-circle"></i> Limpiar filtro
                        </a>
                    </div>
                @endif
            </form>
        </div>
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
                                <td colspan="5" class="text-center py-4 text-muted">No se encontraron mensajes con ese filtro.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection