@extends('layouts.app')

@section('titulo', 'Exito consulta - Brightness.Store') 

@section('contenido')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-warning shadow">
                <div class="card-body text-center p-5">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                    <h2 class="text-warning mb-4">¡Éxito!</h2>

                        {{-- Mensaje personalizado con los datos recibidos del controlador --}}
                        <p class="lead">
                            Hola <strong>{{ $nombre }}</strong>, encantados de estar en contacto, un asesor comercial se contactara contigo 
                            al mail <strong>{{ $email }}</strong>, saludos! 
                        </p>

                        <p class="mt-4">¡Muchas gracias!</p>

                    <a href="/" class="btn btn-outline-warning mt-3">Volver al inicio</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

