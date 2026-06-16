@extends('layouts.app') 

@section('titulo', 'Editar Perfil - Brightness.Store') 

@section('contenido')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            <h2 class="fw-bold text-dark mb-4"><i class="bi bi-person-gear text-warning me-2"></i> Editar Perfil</h2>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    
                    <form action="{{ route('perfil.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h5 class="fw-bold text-dark border-bottom pb-2 mb-4">Datos de Contacto</h5>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted small">Nombre y Apellido</label>
                            <input type="text" class="form-control bg-light" value="{{ $user->name }}" readonly>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">Correo Electrónico</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <h5 class="fw-bold text-dark border-bottom pb-2 mb-4 mt-5">Seguridad</h5>
                        <p class="text-muted small mb-4">Deja estos campos en blanco si no deseas cambiar tu contraseña actual.</p>

                        <div class="mb-3">
                            <label for="password_actual" class="form-label fw-semibold">Contraseña Actual</label>
                            <input type="password" class="form-control @error('password_actual') is-invalid @enderror" id="password_actual" name="password_actual" placeholder="Ingresa tu contraseña actual">
                            @error('password_actual')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_nueva" class="form-label fw-semibold">Nueva Contraseña</label>
                            <input type="password" class="form-control @error('password_nueva') is-invalid @enderror" id="password_nueva" name="password_nueva" placeholder="Mínimo 8 caracteres">
                            @error('password_nueva')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_nueva_confirmation" class="form-label fw-semibold">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control" id="password_nueva_confirmation" name="password_nueva_confirmation" placeholder="Repite la nueva contraseña">
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-warning fw-bold py-2 shadow-sm text-uppercase">
                                Guardar Cambios
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection