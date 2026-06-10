@extends('layouts.app') 

@section('titulo', 'Catalogo - Brightness.Store')

@section('contenido')

<div class="container mt-4 mb-5">
  <div class="row">

    <div class="col-lg-2 col-md-4 col-12 mb-4">
      <div class="sticky-top" style="top: 100px; z-index: 1020;"> 
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
        <div class="col-12">
            
          @if(request('categoria') || request('buscar') || request('en_stock') || request('precio_min') || request('precio_max'))
            <div class="mb-2 d-flex flex-wrap gap-2 align-items-center">
              <span class="text-muted small fw-bold me-1"><i class="bi bi-funnel-fill"></i> Filtros activos:</span>
              
              @if(request('categoria'))
                @php $categoriaSeleccionada = $categoriasDropdown->firstWhere('id', request('categoria')); @endphp
                @if($categoriaSeleccionada)
                  <span class="badge bg-warning text-dark border border-warning shadow-sm d-flex align-items-center px-3 py-2 rounded-pill">
                    Categoría: {{ $categoriaSeleccionada->nombre }}
                    <a href="{{ route('catalogo.index', request()->except('categoria')) }}" class="text-dark ms-2"><i class="bi bi-x-circle-fill fs-6"></i></a>
                  </span>
                @endif
              @endif

              @if(request('buscar'))
                <span class="badge bg-dark text-white shadow-sm d-flex align-items-center px-3 py-2 rounded-pill">
                  Búsqueda: "{{ request('buscar') }}"
                  <a href="{{ route('catalogo.index', request()->except('buscar')) }}" class="text-white ms-2"><i class="bi bi-x-circle-fill fs-6"></i></a>
                </span>
              @endif

              @if(request('en_stock'))
                <span class="badge bg-success text-white shadow-sm d-flex align-items-center px-3 py-2 rounded-pill">
                  Solo con stock
                  <a href="{{ route('catalogo.index', request()->except('en_stock')) }}" class="text-white ms-2"><i class="bi bi-x-circle-fill fs-6"></i></a>
                </span>
              @endif

              @if(request('precio_min') || request('precio_max'))
                <span class="badge text-dark shadow-sm d-flex align-items-center px-3 py-2 rounded-pill" style="background-color: rgb(249, 246, 196);">
                  Precio: @if(request('precio_min')) Mín ${{ request('precio_min') }} @endif @if(request('precio_min') && request('precio_max')) - @endif @if(request('precio_max')) Máx ${{ request('precio_max') }} @endif
                  <a href="{{ route('catalogo.index', request()->except(['precio_min', 'precio_max'])) }}" class="text-dark ms-2"><i class="bi bi-x-circle-fill fs-6"></i></a>
                </span>
              @endif
              
              <a href="{{ route('catalogo.index') }}" class="text-danger small ms-2 text-decoration-none fw-bold">Limpiar todo</a>
            </div>
          @endif

          <form action="{{ route('catalogo.index') }}" method="GET">
            
            @if(request('categoria'))
              <input type="hidden" name="categoria" value="{{ request('categoria') }}">
            @endif

            <div class="d-flex gap-2 mb-3">
              <div class="input-group shadow-sm">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="buscar" class="form-control border-start-0 border-end-0 Border-color-black" 
                      placeholder="Buscar {{ request('categoria') && isset($categoriaSeleccionada) ? 'en ' . $categoriaSeleccionada->nombre : 'productos' }}..." 
                      value="{{ request('buscar') }}">

                <select name="orden_precio" class="form-select btn fw-bold px-4 border-start-0 shadow" style="max-width: 180px; background-color: rgb(248, 233, 69);">
                  <option value="" style="background-color: rgb(255, 243, 116);">Ordenar...</option>
                  <option value="menor" style="background-color: rgb(255, 243, 116);" {{ request('orden_precio') == 'menor' ? 'selected' : '' }}>Menor a Mayor $</option>
                  <option value="mayor" style="background-color: rgb(255, 243, 116);" {{ request('orden_precio') == 'mayor' ? 'selected' : '' }}>Mayor a Menor $</option>
                </select>

                <button type="submit" class="btn btn-warning fw-bold px-4">Buscar</button>
              </div>
            </div>

            <div class="d-flex flex-wrap gap-4 align-items-center bg-light p-3 rounded shadow-sm">
              <div class="form-check form-switch m-0">
                  <input class="form-check-input border-warning" type="checkbox" name="en_stock" value="1" id="filtroStock" onchange="this.form.submit()" {{ request('en_stock') == '1' ? 'checked' : '' }}>
                  <label class="form-check-label fw-bold text-dark" for="filtroStock">
                      Ocultar sin stock
                  </label>
              </div>

              <div class="d-flex align-items-center gap-2 ms-md-auto">
                  <span class="fw-bold text-dark small">Rango de Precio:</span>
                  <div class="input-group input-group-sm" style="max-width: 110px;">
                      <span class="input-group-text bg-white border-warning">$</span>
                      <input type="number" class="form-control border-warning" name="precio_min" placeholder="Mín" min="0" value="{{ request('precio_min') }}">
                  </div>
                  <span class="text-muted fw-bold">-</span>
                  <div class="input-group input-group-sm" style="max-width: 110px;">
                      <span class="input-group-text bg-white border-warning">$</span>
                      <input type="number" class="form-control border-warning" name="precio_max" placeholder="Máx" min="0" value="{{ request('precio_max') }}">
                  </div>
                  <button type="submit" class="btn btn-sm btn-dark fw-bold px-3 shadow-sm">Aplicar</button>
              </div>
            </div>
          </form> </div>
      </div> <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
      {{-- Mensaje de error de stock --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif 
      @forelse($productos as $producto)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm">
                    <img src="{{ asset($producto->url_imagen ?? 'images/default.jpg') }}" class="card-img-top" alt="{{ $producto->nombre }}" style="height: 250px; object-fit: cover;">
                    
                    <div class="card-body d-flex flex-column">
                        <p class="text-muted small mb-1">{{ $producto->categoria->nombre ?? 'Sin categoría' }}</p>
                        <h5 class="card-title fw-bold text-dark mb-3">{{ $producto->nombre }}</h5>
                        <p class="text-muted small mb-1">{{ $producto->descripcion ?? 'Sin descripcion' }}</p>
                        <h4 class="text-success fw-bold mt-auto mb-3">${{ number_format($producto->precio, 2, ',', '.') }}</h4>
                        
                        @if(auth()->check() && auth()->user()->rol === 'admin')
                            <button class="btn btn-secondary w-100 fw-bold mt-auto border-0" disabled style="background-color: #e9ecef; color: #6c757d;">
                                <i class="bi bi-shield-lock me-2"></i>Modo Admin
                            </button>

                        @elseif($producto->stock > 0)
                            @php
                                $cantidadEnCarrito = $carrito[$producto->id] ?? 0;
                            @endphp

                            @if($cantidadEnCarrito >= $producto->stock)
                                <button class="btn btn-secondary w-100 fw-bold mt-auto" disabled>
                                    <i class="bi bi-x-circle me-2"></i>Sin Stock
                                </button>
                            @else
                                <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST" class="mt-auto form-agregar-carrito">
                                    @csrf
                                    <button type="button" class="btn btn-warning w-100 fw-bold shadow-sm btn-agregar" style="background-color: rgb(248, 233, 69);">
                                        <i class="bi bi-cart-plus me-2"></i>Agregar
                                    </button>
                                </form>
                            @endif

                        @else
                            {{-- Stock = 0 --}}
                            <button class="btn btn-secondary w-100 fw-bold mt-auto" disabled>
                                <i class="bi bi-x-circle me-2"></i>Sin Stock
                            </button>

                        @endif {{-- ← cerramos el @if principal --}}

                    </div>
                </div>
            </div>

        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-search text-muted mb-3" style="font-size: 3rem;"></i>
                <h4 class="text-muted fw-bold">No se encontraron productos</h4>
                <p class="text-muted">Intentá ajustando los filtros de búsqueda.</p>
            </div>
        @endforelse
      </div> </div> </div> </div> @auth
    @php
        $itemsEnCarrito = \App\Models\Carrito::where('user_id', auth()->id())->sum('cantidad');
    @endphp
    
    @if($itemsEnCarrito > 0)
        <a href="{{ route('carrito.ver') }}" class="btn shadow-lg position-fixed d-flex align-items-center justify-content-center rounded-circle" style="bottom: 30px; right: 30px; width: 65px; height: 65px; z-index: 1050; background-color: rgb(248, 233, 69); border: 3px solid white; transition: transform 0.2s;">
            <i class="bi bi-cart-fill fs-3 text-dark"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger fs-6 border border-light shadow-sm">
                {{ $itemsEnCarrito }}
            </span>
        </a>
    @endif
@endauth
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-agregar').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const form = btn.closest('.form-agregar-carrito');

            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Verificando...';

            form.submit();
        });
    });
});
</script>
@endsection

