<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Proveedores</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="vendor/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="vendor/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="vendor/jqgrid/ui.jqgrid.bootstrap5.css">
  <link rel="stylesheet" href="vendor/resources/css/dashboard.css">
</head>

<body>
  <!-- Barra de navegación con colores personalizados -->
  <?php include("Navbar.php");?>

  <main class="container mt-5"> <!-- Cambié mt-4 a mt-5 para más espacio arriba -->
    <div class="mb-4"> <!-- Añadí mb-4 para espacio abajo -->
      <button class="btn btn-outline-primary me-2 mt-5" id="save"><i class="fa-solid fa-plus"></i> Agregar</button>
      <button class="btn btn-outline-primary me-2 mt-5"><i class="fa-solid fa-pencil"></i> Modificar</button>
      <button class="btn btn-outline-primary me-2 mt-5"><i class="fa-solid fa-trash-can"></i> Eliminar</button>
    </div>
  </main>

  <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">Agregar Proveedor</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <form id="addForm">
            <div class="mb-3">
              <label for="name" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="name" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" required>
            </div>

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" id="saveBtn">Guardar</button>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <table id="proveedores" class=""></table>
    <div id="navproveedores"></div>
  </div>



  <script src="vendor/bootstrap/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery/jquery.js"></script>
  <script src="vendor/jqgrid/locale.es.js"></script>
  <script src="vendor/jqgrid/jquery.jqgrid.min.js"></script>
  <script src="vendor/resources/js/proveedor.js"></script>
  <script src="vendor/resources/js/formularios.js"></script>
</body>

</html>