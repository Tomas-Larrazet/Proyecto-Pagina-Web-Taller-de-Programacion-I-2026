@extends('layouts.app') 

@section('titulo', 'Inicio - Brightness.Store') 

@section('contenido')
    <section class="py-5 bg-white">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="display-6 fw-bold">Brightness.Store</h2>
                <hr class="mx-auto" style="width: 50px; height: 3px; background-color: #000; opacity: 1;">
                <p class="lead text-muted">
                    Tu estilo es único, y tus accesorios también deberían serlo. 
                    Elegí piezas que no solo resalten tu brillo natural, sino que te hagan sentir especial en cada momento del día. 
                    En Brightness.Store trabajamos con pasión para ofrecerte lo mejor de dos mundos: 
                    somos especialistas en argollas de tendencia para que deslumbres donde vayas, 
                    y creadores de escarapelas con un profundo sello argentino, 
                    para que lleves nuestras raíces con orgullo. 
                    Desde el primer destello hasta el último detalle, estamos acá para iluminar tu look.
                </p>
            </div>
        </div>
    </div>
    </section>

  <div class="container mt-3 mb-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold">Nuestros Destacados</h2>
        <p class="text-muted">Descubrí las piezas más elegidas de Brightness.Store</p>
    </div>        
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div id="carouselExampleRide" class="carousel slide" data-bs-ride="true">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('images/products/escarapela-bandera-mini.jpeg') }}" class="d-block w-100" alt="Escarapela Bandera Mini">
                    </div>
                    
                    <div class="carousel-item">
                        <img src="{{ asset('images/products/argolla-clasica.jpeg') }}" class="d-block w-100" alt="Argolla Clásica">                    
                    </div>

                    <div class="carousel-item">
                        <img src="{{asset('images/products/escarapela-circular-mini.jpeg')}}" class="d-block w-100" alt="Argolla Clásica">
                    </div>
                    
                    <div class="carousel-item">
                        <img src="{{ asset('images/products/argolla-vibe.jpeg') }}" class="d-block w-100" alt="Argolla Vibe">
                    </div>
                </div>
                
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </div>
        </div>
    </div>
    </div>

  <section class="py-5" style="background-color: rgb(249, 246, 196);">
    <div class="container text-center mt-3">
        <h2 class="fw-bold mb-5">Lo que dicen nuestros clientes</h2>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-3 shadow-sm h-100">
                    <i class="bi bi-quote fs-1 text-muted"></i>
                    <p class="fst-italic my-3">
                        "Las argollas son hermosas y no me dan alergia por el acero quirúrgico. ¡Súper recomendadas para pieles sensibles!"
                    </p>
                    <hr class="w-25 mx-auto">
                    <h6 class="fw-bold mb-0">— Lucía G.</h6>
                    <small class="text-muted">Corrientes Capital</small>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-4 bg-white rounded-3 shadow-sm h-100">
                    <i class="bi bi-quote fs-1 text-muted"></i>
                    <p class="fst-italic my-3">
                        "Compré escarapelas para el acto del colegio de mis hijos y son soñadas. El detalle artesanal se nota a simple vista."
                    </p>
                    <hr class="w-25 mx-auto">
                    <h6 class="fw-bold mb-0">— Martina S.</h6>
                    <small class="text-muted">Resistencia, Chaco</small>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-4 bg-white rounded-3 shadow-sm h-100">
                    <i class="bi bi-quote fs-1 text-muted"></i>
                    <p class="fst-italic my-3">
                        "El envío llegó rapidísimo a Buenos Aires y el packaging es un amor. Ideal para hacer un regalo especial."
                    </p>
                    <hr class="w-25 mx-auto">
                    <h6 class="fw-bold mb-0">— Valeria R.</h6>
                    <small class="text-muted">Buenos Aires</small>
                </div>
            </div>
              
        </div>
    </div>
    </section>

    <section class="py-5" style="background-color: rgb(249, 249, 249);">
    <div class="container text-center">
        <h2 class="fw-bold mb-5">Nuestras categorias</h2>
        
        <div class="row g-4 justify-content-center">
            @foreach($categorias as $categoria)
                <div class="col-md-3">
                   <div class="p-4 header-custom rounded-3 shadow-sm h-100 d-flex align-items-center justify-content-center">                    
                    <a href="{{ route('catalogo.index', ['categoria' => $categoria->id]) }}" class="btn btn-dark px-4 py-2 rounded-pill w-100">
                        {{ $categoria->nombre }}                       
                    </a>  
                    </div>
                </div>
            @endforeach
            <div class="col-12 mt-5">
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="{{ route('catalogo.index') }}" class="btn btn-dark px-4 py-2 rounded-pill">Ver Catálogo Completo</a>
                    <a href="/comercializacion" class="btn btn-dark px-4 py-2 rounded-pill">+ Info de compras</a>
                </div>
            </div>
    </div>
    </section>
@endsection

   