<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Offcanvas dark navbar</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="vendor/bootstrap/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
  
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand ms-2" href="#"><i class="bi bi-star-half"></i> SIACEIN</a> <!-- Ajuste de margen a la izquierda -->

   
    <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel"><i class="bi bi-star-half"></i> SIACEIN</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="Proveedor"><i class="bi bi-person"></i> Proveedores</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="bi bi-layout-text-sidebar-reverse"></i> Categorias</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link dropdown-toggle" href="#"><i class="bi bi-person"></i>Productos</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="bi bi-gear"></i> Configuración</a>
          </li>
        </ul>
       
      </div>
      <div class="d-flex justify-content-center text-light py-2">
          <a href="#" class="btn btn-outline-light fw-bold "><i class="bi bi-person-walking"></i> Cerrar Sesión</a>
        </div>
    </div>
  </div>
</nav>


<div class="container-fluid mt-5">
  <h1 class="mt-4">Contenido Principal</h1>
  <p>Este es el contenido principal de la página. Aquí puedes colocar todo tu contenido.</p>
</div>


<script src="vendor/bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>
