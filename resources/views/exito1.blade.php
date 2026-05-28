@extends('layouts.app') 

@section('titulo', 'Exito registro - Brightness.Store') 

@section('contenido')
    
<main class="flex-grow-1 d-flex align-items-center justify-content-center py-5">
  <div class="container text-center">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card border-0 shadow-lg p-5">
          <div class="card-body">
            
            <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
            
            <h2 class="fw-bold mt-4">¡Registro Exitoso!</h2>
            <p class="text-muted fs-5 mt-3">
              Tu cuenta ha sido creada correctamente. Ya sos parte de la comunidad.
            </p>

          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection

