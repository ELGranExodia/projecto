<!-- Barra de navegación con colores personalizados -->
<nav class="navbar navbar-dark fixed-top bg-custom">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar"
            aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand ms-2" href="#">
            <img src="vendor/resources/img/logoinframen.png" alt="Logo Inframen"
                class="img-fluid rounded-circle avatar me-2" style="width: 40px;">
            USUARIO
        </a>
        <div class="offcanvas offcanvas-start text-bg-secondary" tabindex="-1" id="offcanvasDarkNavbar"
            aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel"><i class=""></i> COMEDOR</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard"><i class="bi bi-layout-text-sidebar-reverse"></i> Inicio</a>
                    </li>
                    <li class="dropdown-item">
                        <a class="nav-link" href="/estudiantes"><i class="bi bi-person"></i> Estudiantes</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person"></i> Registro de comida
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/registrocomida">Registro de Comida</a></li>
                            <li><a class="dropdown-item" href="/entregacomida">Entrega de Comida</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-gear"></i> Configuración</a>
                    </li>
                </ul>
            </div>
            <div class="d-flex justify-content-center text-light py-2">
                <a href="/" class="btn btn-outline-light fw-bold"><i class="bi bi-person-walking"></i> Cerrar Sesión</a>
            </div>
        </div>
    </div>
</nav>