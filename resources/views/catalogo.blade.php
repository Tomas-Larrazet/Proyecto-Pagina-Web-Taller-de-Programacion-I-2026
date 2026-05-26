@extends('layouts.app') 

@section('titulo', 'Catalogo - Brightness.Store')

@section('contenido')

<div class="container mt-4">
  <div class="row">
      
    <div class="col-lg-2 col-md-4 col-12 mb-4">
      <div class="sticky-top" style="top: 20px; z-index: 1020;">
        <div class="bg-light p-3 rounded shadow-sm">          

          <h5 class="mb-3 fw-bold">Categorías</h5>

          <div class="dropdown">
            <a class="btn btn-warning dropdown-toggle w-100" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Productos
            </a>
            <ul class="dropdown-menu w-100">
              <li><a class="dropdown-item" href="{{ route('catalogo.index') }}">Todos</a></li>
              <li><hr class="dropdown-divider"></li>

              @foreach($categoriasDropdown as $categoria)
                <li>
                  <a class="dropdown-item" href="{{ route('catalogo.index', ['categoria' => $categoria->id]) }}">
                  {{ $categoria->nombre }}
                  </a>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
     
    <div class="col-lg-10 col-md-8 col-12">
      <div class="row ">
        
        @foreach($productos as $producto)
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4">
          <div class="card h-100 shadow-sm">
            <img src="{{asset($producto->url_imagen)}}" class="card-img-top img-product" alt="Producto: {{ $producto->nombre }}">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">{{ $producto->nombre }}</h5>
              <p class="card-text">{{ $producto->descripcion }}</p>
              <span class="badge bg-success fs-6 mt-auto">${{ number_format($producto->precio, 2, ',', '.') }}</span>
            </div>
          </div>
        </div>
        @endforeach

        @if($productos->isEmpty())
          <div class="col-12">
            <div class="alert alert-warning text-center my-4">
              No se encontraron productos en esta categoría.
            </div>
          </div>
        @endif
        
      </div>
    </div>
  </div>
</div>
@endsection

