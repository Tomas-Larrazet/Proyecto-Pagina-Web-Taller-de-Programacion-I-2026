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
      <div class="row mb-4">

        <div class="row mb-4">
          <div class="col-12">
            
            @if(request('categoria') || request('buscar'))
              <div class="mb-2 d-flex flex-wrap gap-2 align-items-center">
                <span class="text-muted small fw-bold me-1"><i class="bi bi-funnel-fill"></i> Filtros activos:</span>
                
                @if(request('categoria'))
                  @php
                    // Buscamos el nombre de la categoría usando el ID que está en la URL
                    $categoriaSeleccionada = $categoriasDropdown->firstWhere('id', request('categoria'));
                  @endphp
                  
                  @if($categoriaSeleccionada)
                    <span class="badge bg-warning text-dark border border-warning shadow-sm d-flex align-items-center px-3 py-2 rounded-pill">
                      Categoría: {{ $categoriaSeleccionada->nombre }}
                      <a href="{{ route('catalogo.index', ['buscar' => request('buscar')]) }}" class="text-dark ms-2" title="Quitar filtro">
                        <i class="bi bi-x-circle-fill fs-6"></i>
                      </a>
                    </span>
                  @endif
                @endif

                @if(request('buscar'))
                  <span class="badge bg-dark text-white shadow-sm d-flex align-items-center px-3 py-2 rounded-pill">
                    Búsqueda: "{{ request('buscar') }}"
                    <a href="{{ route('catalogo.index', ['categoria' => request('categoria')]) }}" class="text-white ms-2" title="Quitar filtro">
                      <i class="bi bi-x-circle-fill fs-6"></i>
                    </a>
                  </span>
                @endif
                
                <a href="{{ route('catalogo.index') }}" class="text-danger small ms-2 text-decoration-none fw-bold">Limpiar todo</a>
              </div>
            @endif

            <form action="{{ route('catalogo.index') }}" method="GET" class="d-flex gap-2">
              
              @if(request('categoria'))
                <input type="hidden" name="categoria" value="{{ request('categoria') }}">
              @endif

              <div class="input-group shadow-sm">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="buscar" class="form-control border-start-0" 
                      placeholder="Buscar {{ request('categoria') && isset($categoriaSeleccionada) ? 'en ' . $categoriaSeleccionada->nombre : 'productos' }}..." 
                      value="{{ request('buscar') }}">
                <button type="submit" class="btn btn-warning fw-bold px-4">Buscar</button>
              </div>

            </form>
          </div>
        </div>

      </div>

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
            <div class="alert alert-warning text-center my-4 shadow-sm">
              <i class="bi bi-exclamation-circle fs-4 d-block mb-2"></i>
              @if(request('buscar'))
                No encontramos productos que coincidan con "<strong>{{ request('buscar') }}</strong>"
                @if(request('categoria')) en esta categoría @endif.
              @else
                No se encontraron productos en esta categoría.
              @endif
            </div>
          </div>
        @endif
        
      </div>
    </div>
  </div>
</div>
@endsection

