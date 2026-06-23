@extends('layouts.app') 

@section('titulo', 'Login - Brightness.Store') 

@section('contenido')
  <div class="container mt-5 mb-5">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card border-0 shadow-lg"> 
          <div class="card-body p-5"> 
            
            <div class="text-center mb-4">
              <i class="bi bi-person-circle text-muted" style="font-size: 3rem;"></i>
              <h3 class="mt-2 fw-bold">Iniciar Sesión</h3> 
              <p class="text-muted small">Ingresá a tu cuenta de Brightness.Store</p>
            </div>

            <form action="{{ url('/logIn') }}" method="POST">
             @csrf
             <div class="mb-4">
               <label class="form-label fw-bold">Email</label>
               <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" placeholder="ejemplo@correo.com" value="{{ old('email') }}" required> 
               @error('email')
                   <div class="invalid-feedback fw-bold">
                       <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                   </div>
               @enderror
             </div>

             <div class="mb-4">
               <label class="form-label fw-bold">Contraseña</label>
               <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="Tu contraseña" required> 
               @error('password')
                   <div class="invalid-feedback fw-bold">
                       <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                   </div>
               @enderror
             </div>
                  
             <div class="d-grid mb-3">
               <button type="submit" class="btn btn-dark btn-lg">Ingresar</button>
             </div>

             <div class="text-center mt-4">
                 <p class="small mb-1"><a class="text-decoration-none text-muted">¿Olvidaste tu contraseña?</a></p>
                 <p class="small">¿No tenés cuenta? <a href="/registroUsuario" class="text-decoration-none fw-bold text-dark">Registrate acá</a></p>
             </div>

            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
@endsection



  
  