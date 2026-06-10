<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('principal', 'Brightness.Store')</title>
    <link rel="icon" type="image/x-icon" href="/images/logo/favicon.jpeg">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}?v={{ time() }}">
</head>
<body class="d-flex flex-column min-vh-100">

    <header id="cabecera">
        <div class="bg-primary text-white py-1">
            <div id="miniCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active text-center"><small><i class="bi bi-truck me-2"></i> Envíos gratis en compras superiores a $45.000</small></div>
                    <div class="carousel-item text-center"><small><i class="bi bi-credit-card me-2"></i> 3 Cuotas sin interés con todas las tarjetas</small></div>
                    <div class="carousel-item text-center"><small><i class="bi bi-gem me-2"></i> 15% OFF abonando por transferencia</small></div>
                </div>
            </div>
        </div>

        <div class="container-fluid py-3 text-center" style="background-color: rgb(249, 246, 196);">
            <a href="/">
                <img src="{{ asset('images/logo/logo.jpeg') }}" alt="Logo de Brightness.Store" class="img-fluid" style="max-height: 100px; mix-blend-mode: multiply;">
            </a>
        </div>
    </header>

    <nav id="miNavbar" class="navbar navbar-expand-lg navbar-light shadow-sm w-100" style="z-index: 1030; background-color: rgb(249, 246, 196); transition: all 0.3s ease-in-out;"> 
        <div class="container justify-content-center">
            
            <button class="navbar-toggler mb-2 border-0 shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#menuNavegacion" aria-controls="menuNavegacion" aria-expanded="false" aria-label="Abrir menú">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-center w-100" id="menuNavegacion">
                <ul class="navbar-nav align-items-center text-center gap-3 gap-lg-4 m-0">
                    @if(auth()->check() && auth()->user()->rol === 'admin')
                        <li class="nav-item"><a class="nav-link {{ request()->is('admin*') ? 'active fw-bold border-bottom border-warning border-2' : '' }}" href="{{ route('admin.panel-principal') }}">Panel de Control</a></li>
                    @endif
                    <li class="nav-item"><a class="nav-link {{ request()->is('catalogo*') ? 'active fw-bold border-bottom border-warning border-2' : '' }}" href="/catalogo">Catálogo</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('contactos') ? 'active fw-bold border-bottom border-warning border-2' : '' }}" href="/contactos">Contactos</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('comercializacion') ? 'active fw-bold border-bottom border-warning border-2' : '' }}" href="/comercializacion">Comercialización</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('quienes-somos') ? 'active fw-bold border-bottom border-warning border-2' : '' }}" href="/quienes-somos">Quienes Somos</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('terminos-y-uso') ? 'active fw-bold border-bottom border-warning border-2' : '' }}" href="/terminos-y-uso">Términos</a></li>
                    
                    <li class="nav-item d-none d-lg-block"><div class="vr" style="height: 25px; opacity: 0.2;"></div></li>
                    <hr class="d-lg-none w-50 mx-auto my-1" style="opacity: 0.1;">

                    @auth
                        <li class="nav-item">
                            <a href="{{ route('carrito.ver') }}" class="btn btn-outline-dark bg-dark position-relative d-flex align-items-center rounded-pill px-3 py-2 border-0 shadow-sm">
                                <i class="bi bi-cart3 fs-5 text-warning"></i>
                                <span class="ms-2 d-none d-md-inline fw-bold text-warning">Mi Carrito</span>
                                
                                @auth
                                    @php
                                        // Calculamos cuántos productos tiene este usuario en su carrito
                                        $cantidadCarrito = \App\Models\Carrito::where('user_id', auth()->id())->sum('cantidad');
                                    @endphp
                                    
                                    @if($cantidadCarrito > 0)
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger shadow-sm">
                                            {{ $cantidadCarrito }}
                                        </span>
                                    @endif
                                @endauth
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 p-0" href="#" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="rounded-circle bg-dark text-warning d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px;">
                                    <i class="bi bi-person-fill fs-5"></i>
                                </div>
                                <span class="d-none d-lg-inline text-dark fw-semibold">{{ auth()->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-warning mt-2">
                                <li><a class="dropdown-item" href="/mis-compras"><i class="bi bi-bag-check text-muted"></i> Mis Compras</a></li>
                                <li><a class="dropdown-item" href="/perfil"><i class="bi bi-gear text-muted"></i> Editar Perfil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ url('/logOut') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth

                    @guest
                        <li class="nav-item">
                            <a href="/logIn" class="btn btn-outline-dark rounded-pill px-4 fw-bold shadow-sm">
                                <i class="bi bi-person-circle me-2"></i> Iniciar Sesión
                            </a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
<main class="flex-grow-1">
    @yield('contenido')
</main>

    <footer class="footer-custom text-black mt-5 pt-4 pb-2">
        <div class="container">
            <div class="row">

                
                <div class="col-md-4 mb-3">
                    <h5><a href="/" class="footer-link">Brightness.Store</a></h5>
                    <p class="small">
                    Tienda de accesorios. Calidad y estilo para cada ocasión.
                    </p>
                    <a href="/registroUsuario" class="footer-link">Registrate</a>
                </div>

                
                <div class="col-md-4 mb-3">
                    <h5>Información</h5>
                    <ul class="list-unstyled">
                    <li><a href="/terminos-y-uso" class="footer-link">Términos y condiciones</a></li>
                    <li><a href="/contactos" class="footer-link">Contactos</a></li>
                    <li><a href="/quienes-somos" class="footer-link">Quiénes somos</a></li>
                    </ul>
                </div>

                
                <div class="col-md-4 mb-3">
                    <h5>Seguinos</h5>
                    <a href="https://www.instagram.com/brightness__store/" 
                    class="footer-link d-block"
                    target="_blank" 
                    rel="noopener noreferrer">
                    <i class="bi bi-instagram"></i> Instagram
                    </a>
                </div>

            </div>

            
            <hr class="border-light">

            <div class="text-center small">
                © 2026 Brightness.Store - Todos los derechos reservados
            </div>
        </div>
    </footer>

    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    @auth
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
    document.addEventListener("DOMContentLoaded", function() {
        // Detectamos el header y la barra
        var cabecera = document.getElementById('cabecera');
        var navbar = document.getElementById('miNavbar');
        
        window.addEventListener('scroll', function() {
            // Calculamos cuánto mide la cabecera (logo + envíos)
            var alturaCabecera = cabecera.offsetHeight;
            
            // Si el usuario bajó más allá de la cabecera...
            if (window.scrollY >= alturaCabecera) {
                // Clavamos la barra a la pantalla
                navbar.classList.add('fixed-top');
                // Empujamos el cuerpo de la página hacia abajo para que el catálogo no pegue un salto
                document.body.style.paddingTop = navbar.offsetHeight + 'px';
            } else {
                // Si vuelve a subir, la soltamos
                navbar.classList.remove('fixed-top');
                document.body.style.paddingTop = '0';
            }
        });
    });
</script>
    <div class="modal fade" id="promoModal" tabindex="-1" aria-labelledby="promoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-0 p-4">
        
        <div class="modal-header border-0 pb-0 justify-content-end p-2">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="cerrarPromoX"></button>
        </div>
        
        <div class="modal-body text-center pt-0 px-md-5">
            
            <h3 class="fw-bold tracking-widest mb-1" style="letter-spacing: 4px;">BRIGHTNESS STORE</h3>
            <h2 class="fw-bold mb-4">Tiene un regalo para vos.</h2>
            
            <p class="text-muted mb-2">REGISTRÁNDOTE</p>
            <p class="text-muted mb-4">Aprovechá un descuento en tu primera compra.</p>
            
            <p class="text-muted mb-1">Ingresando el código:</p>
            <h2 class="fw-bold mb-3" style="color: #38d381;">Brightness</h2>
            <p class="text-muted mb-4">en tu carrito de compras.</p>
            
            <a href="{{ route('register') }}" class="btn w-100 fw-bold py-2 mb-3 text-white rounded-0 shadow-sm" style="background-color: #38d381; font-size: 1.1rem;" id="btnIrRegistro">
                Quiero registrarme
            </a>

            <button type="button" class="btn btn-link text-danger text-decoration-none fw-bold" data-bs-dismiss="modal" id="cerrarPromoTxt">
                No, gracias
            </button>
            
            <p class="text-dark small mt-4 mb-0">Cupón válido para nuevos suscriptores.</p>
        </div>
        
        </div>
    </div>
</div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                
                // Verificamos en la memoria del navegador si ya vio la promo
                if (!localStorage.getItem('promo_brightness_vista')) {
                
                // Esperamos 2 segundos y mostramos el cartel
                setTimeout(function() {
                    var myPromoModal = new bootstrap.Modal(document.getElementById('promoModal'));
                    myPromoModal.show();
                }, 1000);
                
                }

                // LISTA DE BOTONES QUE SILENCIAN LA PROMO:
                // 1. La cruz de arriba
                document.getElementById('cerrarPromoX').addEventListener('click', silenciarPromo);
                // 2. El texto "No, gracias"
                document.getElementById('cerrarPromoTxt').addEventListener('click', silenciarPromo);
                // 3. ¡NUEVO! El botón verde de registrarse
                document.getElementById('btnIrRegistro').addEventListener('click', silenciarPromo);

                function silenciarPromo() {
                // Esto guarda una marca invisible en su navegador
                localStorage.setItem('promo_brightness_vista', 'true');
                }
                
            });
    </script>
</body>
</html>








    

    
