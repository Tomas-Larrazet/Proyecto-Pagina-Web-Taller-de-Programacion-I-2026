@extends('admin.panel') 

@section('titulo', 'Usuarios registrados - Brightness.Store')

@section('contenido')

<div class="container mt-3 mt-md-5">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
        <h2 class="h4 h-sm-2 mb-0">Gestión de Usuarios</h2>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.panel-principal') }}" class="btn btn-secondary btn-sm">Volver al Panel</a>
            <a href="{{ route('admin.usuarios.create_admin') }}" class="btn btn-success btn-sm">+ Nuevo Admin</a>
        </div>
    </div>

    <div class="card shadow-sm border-warning">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">Clientes Registrados</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="d-none d-md-table-cell">ID</th>
                            <th>Nombre</th>
                            <th class="d-none d-md-table-cell">Correo Electrónico</th>
                            <th class="d-none d-md-table-cell">Fecha de Registro</th>
                            <th>Rol</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $usuario)
                            <tr>
                                <td class="d-none d-md-table-cell">#{{ $usuario->id }}</td>
                                <td class="fw-bold">
                                    {{ $usuario->name }}
                                    <div class="d-md-none text-muted small fw-normal mt-1">
                                        #{{ $usuario->id }} · {{ $usuario->created_at->format('d/m/Y') }}<br>
                                        <a href="mailto:{{ $usuario->email }}" class="text-decoration-none">{{ $usuario->email }}</a>
                                    </div>
                                </td>
                                <td class="d-none d-md-table-cell"><a href="mailto:{{ $usuario->email }}" class="text-decoration-none">{{ $usuario->email }}</a></td>
                                <td class="d-none d-md-table-cell">{{ $usuario->created_at->format('d/m/Y') }}</td>
                                
                                <td>
                                    @if($usuario->rol === 'admin' || $usuario->is_admin)
                                        <span class="badge bg-danger">Administrador</span>
                                    @else
                                        <span class="badge bg-primary">Cliente</span>
                                    @endif
                                </td>
                                <td>
                                @if($usuario->id !== auth()->id())
                                    <form action="{{ route('admin.usuarios.cambiarRol', $usuario->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <select name="rol" class="form-select form-select-sm fw-bold {{ $usuario->rol === 'admin' ? 'text-danger' : 'text-primary' }}" style="width: auto;" onchange="this.form.submit()">
                                            <option value="cliente" {{ $usuario->rol !== 'admin' ? 'selected' : '' }}>Cliente</option>
                                            <option value="admin" {{ $usuario->rol === 'admin' ? 'selected' : '' }}>Administrador</option>
                                        </select>
                                    </form>
                                @else
                                    @if($usuario->rol === 'admin')
                                        <span class="badge bg-danger">Administrador</span>
                                    @else
                                        <span class="badge bg-primary">Cliente</span>
                                    @endif
                                @endif
                            </td>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Aún no hay usuarios registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection