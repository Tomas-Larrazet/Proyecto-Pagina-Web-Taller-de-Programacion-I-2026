@extends('layouts.app') 

@section('titulo', 'Catalogo - Brightness.Store')

@section('contenido')

<div class="container mt-4">
  <div class="row">
      
    <div class="col-lg-2 col-md-4 col-12 mb-4">
      <div class="sticky-top" style="top: 40px; z-index: 1020;">
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

                <input type="text" name="buscar" class="form-control border-start-0 border-end-0 Border-color-black" 
                      placeholder="Buscar {{ request('categoria') && isset($categoriaSeleccionada) ? 'en ' . $categoriaSeleccionada->nombre : 'productos' }}..." 
                      value="{{ request('buscar') }}">

                <select name="orden_precio" class="form-select btn fw-bold px-4 border-start-0 shadow" style="max-width: 180px; background-color: rgb(248, 233, 69);">
                  <option value="Precio" style=" background-color: rgb(255, 243, 116);">Precio</option>
                  <option value="menor " style=" background-color: rgb(255, 243, 116);" {{ request('orden_precio') == 'menor' ? 'selected' : '' }}>Menor a Mayor $  </option>
                  <option value="mayor" style=" background-color: rgb(255, 243, 116);" {{ request('orden_precio') == 'mayor' ? 'selected' : '' }}>Mayor a Menor $  </option>
                </select>

                <button type="submit" class="btn btn-warning fw-bold px-4">Buscar</button>
              </div>

            </form>
          </div>
        </div>

      </div>

      <div class="row ">
        
        @foreach($productos as $producto)
          <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4">
            <div class="card h-100 shadow border-0"> <div class="position-relative">
                
                <img src="{{ asset($producto->url_imagen) }}" 
                    class="card-img-top img-product {{ $producto->stock <= 0 ? 'opacity-75' : '' }}" 
                    alt="Producto: {{ $producto->nombre }}"
                    style="object-fit: cover; height: 250px;"> @if($producto->stock <= 0)
                  <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center rounded-top" 
                      style="background-color: rgba(0, 0, 0, 0.4);"> <span class="badge bg-danger text-white fs-5 px-3 py-2 shadow text-uppercase" style="letter-spacing: 1px;">
                      Sin Stock
                    </span>
                    
                  </div>
                @endif
                
              </div>

              <div class="card-body d-flex flex-column">
                <h5 class="card-title fw-bold text-dark mb-1">{{ $producto->nombre }}</h5>
                <p class="card-text text-muted small mb-3">{{ $producto->descripcion }}</p>
                
                <div class="mt-auto d-flex flex-column gap-2">
                  <span class="badge bg-success fs-6 align-self-start mb-2">${{ number_format($producto->precio, 2, ',', '.') }}</span>
                  
                  @auth
                    @if(auth()->user()->rol == 'admin') <button type="button" class="btn btn-secondary w-100 fw-bold shadow-sm" disabled>
                        <i class="bi bi-ban me-1"></i> Modo Admin
                      </button>
                    @else
                      <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST" class="w-100">
                        @csrf
                        <button type="submit" class="btn btn-dark w-100 fw-bold shadow-sm" {{ $producto->stock <= 0 ? 'disabled' : '' }}>
                          <i class="bi bi-cart-plus me-1"></i> Agregar al Carrito
                        </button>
                      </form>
                    @endif
                  @endauth

                  @guest
                  <button type="button" class="btn btn-dark w-100 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalRegistroRequerido" {{ $producto->stock <= 0 ? 'disabled' : '' }}>
                    <i class="bi bi-cart-plus me-1"></i> Agregar al Carrito
                  </button>
                  @endguest 
                </div>

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



@guest
<div class="modal fade" id="modalRegistroRequerido" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0">
      
      <div class="modal-header border-bottom-0 pb-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      
      <div class="modal-body text-center pb-5 px-4">
        <i class="bi bi-person-lock text-warning mb-3 d-block" style="font-size: 4rem;"></i>
        
        <h4 class="fw-bold text-dark mb-3">¡Solo un paso más!</h4>
        <p class="text-muted fs-6 mb-4">
          Para empezar a comprar y sumar productos al carrito, primero debes iniciar sesión o crear una cuenta gratuita en <strong>Brightness.Store</strong>.
        </p>
        
        <div class="d-flex justify-content-center gap-3">
          <a href="{{ url('/logIn') }}" class="btn btn-outline-dark px-4 py-2 fw-bold w-50">Ingresar</a>
          <a href="{{ url('/registroUsuario') }}" class="btn btn-warning px-4 py-2 fw-bold w-50">Registrarme</a>
        </div>
      </div>

    </div>
  </div>
</div>
@endguest


@auth
    @if(session('carrito') && count(session('carrito')) > 0)
        <a href="{{ route('carrito.ver') }}" class="btn btn-warning position-fixed shadow-lg d-flex align-items-center justify-content-center btn-flotante-carrito" title="Ver mi carrito">
            <i class="bi bi-cart-fill fs-3 text-dark"></i>
            
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light border-2" style="font-size: 0.85rem;">
                {{ array_sum(array_column(session('carrito'), 'cantidad')) }}
            </span>
        </a>
    @endif
@endauth


@endsection

