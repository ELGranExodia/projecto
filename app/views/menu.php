<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="vendor/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="vendor/resources/css/dashboard.css"> <!-- Asegúrate de tener enlazado tu archivo CSS -->
</head>

<body>

  <!-- Barra de navegación con colores personalizados -->
  <nav class="navbar navbar-dark fixed-top bg-custom">
    <div class="container-fluid">

      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar"
        aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Aquí añadimos la imagen al lado de USUARIO -->
      <a class="navbar-brand ms-2" href="#">
        <img src="vendor/resources/img/logoinframen.png" alt="Logo Inframen"
          class="img-fluid rounded-circle avatar me-2"> <!-- Ajusta el tamaño y el margen de la imagen -->
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
              <a class="nav-link active" aria-current="page" href="/proveedores"><i class="bi bi-person"></i> Table</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/menu"><i class="bi bi-layout-text-sidebar-reverse"></i> Menu</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="bi bi-person"></i> Productos
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="/desayunos">Desayunos</a></li>
                <li><a class="dropdown-item" href="#">Almuerzos</a></li>
              </ul>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="#"><i class="bi bi-gear"></i> Configuración</a>
            </li>
          </ul>

        </div>
        <div class="d-flex justify-content-center text-light py-2">
          <a href="/" class="btn btn-outline-light fw-bold "><i class="bi bi-person-walking"></i> Cerrar Sesión</a>
        </div>
      </div>
    </div>
  </nav>


  <!-- Contenido Principal -->
  <div class="container-fluid" id="contenidod">
    <div class="card" style="width: 18rem;">
      <img src="..." class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
          content.</p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
      </div>
    </div>
  </div>



  <script src="vendor/bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>