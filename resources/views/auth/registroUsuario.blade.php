@extends('layouts.app') 

@section('titulo', 'Registro de Usuario - Brightness.Store') 

@section('contenido')
  <div class="container mt-5 mb-5">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card border-warning shadow"> 
          <div class="card-body p-4">
            <h2 class="text-center mb-4">Formulario de registro</h2> 
            
            <form action="{{ url('/registroUsuario') }}" method="POST">
             @csrf

             <div class="mb-3"> 
              <label class="form-label">Nombre Completo</label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                    placeholder="Ingrese su nombre" value="{{ old('name') }}" required
                    onkeypress="return /[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]/.test(event.key)"> 
              @error('name') <div class="invalid-feedback">{{ $message }}</div>@enderror
          </div> 
             
             <div class="mb-3">
               <label class="form-label">Email</label>
               <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Ingrese su email" value="{{ old('email') }}" required> 
               @error('email') <div class="invalid-feedback">{{ $message }}</div>@enderror
             </div>
               
             <div class="mb-3">
               <label class="form-label">Direccion (opcional)</label>
               <input type="text" name="direccion" class="form-control" placeholder="Ingrese su direccion" value="{{ old('direccion') }}"> 
             </div>

             <div class="mb-3">
              <label class="form-label">Telefono (opcional)</label>
              <input type="text" name="telefono" class="form-control" 
                    placeholder="Ingrese su telefono" value="{{ old('telefono') }}"
                    onkeypress="return /[0-9]/.test(event.key)"> 
            </div>

             <div class="mb-3">
               <label class="form-label">Contraseña</label>
               <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Ingrese su contraseña" required> 
               @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
             </div>

             <div class="mb-3">
               <label class="form-label">Repita contraseña</label>
               <input type="password" name="password_confirmation" class="form-control" placeholder="Ingrese nuevamente su contraseña" required> 
             </div>
                  
             <div class="d-grid mt-4">
               <button type="submit" class="btn btn-dark btn-lg">Confirmar registro</button>
             </div>
            </form>

             <div class="text-center mt-3">
               <p>¿Ya tienes una cuenta? <a href="/logIn">Inicia sesión</a></p>
             </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection



  