<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema para la gestion de la entrega de comida.">
    <meta name="author" content="David Ventura">
    <link rel="icon" href="vendor/resources/img/logoinframen.ico" sizes="32x32">
    <title>Estudiantes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="vendor/jqgrid/ui.jqgrid.bootstrap5.css">
    <link rel="stylesheet" href="vendor/resources/css/dashboard.css">
    <link rel="stylesheet" href="vendor/alertify/alertify.min.css">
    <link rel="stylesheet" href="vendor/formvalidation/formvalidation.min.css">
</head>

<body>
    <!-- Barra de navegación con colores personalizados -->
    <?php include("Navbar.php"); ?>

    <main class="container mt-5"> <!-- Cambié mt-4 a mt-5 para más espacio arriba -->
        <div class="mb-4"> <!-- Añadí mb-4 para espacio abajo -->
            <button class="btn btn-outline-primary me-2 mt-5" onclick="agregar()"><i class="fa-solid fa-plus"></i>
                Agregar</button>
            <button class="btn btn-outline-primary me-2 mt-5" onclick="editar()"><i class="fa-solid fa-pen"></i>
                Modificar</button>
            <button class="btn btn-outline-primary me-2 mt-5" onclick="eliminar()">
                <i class="fa-solid fa-trash-alt"></i>
                Eliminar</button>
            <button class="btn btn-outline-primary me-2 mt-5" onclick="informetabla()">
                <i class="fa-solid fa-print"></i>
                Informe</button>
        </div>
    </main>
    <!-- Filtros por Sección y Bachillerato -->
    <div class="container">
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="filtroSeccion" class="form-label">Filtrar por Sección</label>
            <select id="filtroSeccion" class="form-select">
                <option value="">Todas las Secciones</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="filtroBachillerato" class="form-label">Filtrar por Bachillerato</label>
            <select id="filtroBachillerato" class="form-select">
                <option value="">Todos los Bachilleratos</option>
            </select>
        </div>
    </div>
</div>
    <div class="container">
        <table id="estudiantes"></table>
        <div id="navestudiantes"></div>
    </div>
    <!-- Ventanas Modales -->
    <!-- Modal para editar estudiante -->
    <div class="modal fade" id="modalEstudiante" tabindex="-1" aria-labelledby="modalEstudianteLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEstudianteLabel">Editar Estudiante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEstudiante">
                    <div class="modal-body">
                        <div class="mb-3 form-group mb-3 row">
                            <label for="numero_orden" class="col-form-label col-md-6">Número de Orden</label>
                            <input type="text" class="form-control col-md-6" id="numero_orden" name="numero_orden">
                        </div>
                        <div class="mb-3 form-group mb-3 row">
                            <label for="nombre_completo" class="col-form-label col-md-6">Nombre Completo</label>
                            <input type="text" class="form-control col-md-6" id="nombre_completo"
                                name="nombre_completo">
                        </div>
                        <div class="mb-3 form-group mb-3 row">
                            <label for="seccion" class="col-form-label col-md-6">Sección</label>
                            <input type="text" class="form-control col-md-6" id="seccion" name="seccion">
                        </div>
                        <div class="mb-3 form-group mb-3 row">
                            <label for="bachillerato" class="col-form-label col-md-6">Bachillerato</label>
                            <input type="text" class="form-control col-md-6" id="bachillerato" name="bachillerato">
                        </div>
                        <div class="mb-3 form-group mb-3 row">
                            <label for="nie" class="col-form-label col-md-6">NIE</label>
                            <input type="text" class="form-control col-md-6" id="nie" name="nie">
                        </div>
                        <div class="mb-3 form-group mb-3 row">
                            <label for="anio" class="col-form-label col-md-6">Año</label>
                            <input type="text" class="form-control col-md-6" id="anio" name="anio">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery/jquery.js"></script>
    <script src="vendor/jqgrid/grid.locale.es.js"></script>
    <script src="vendor/jqgrid/jquery.jqgrid.min.js"></script>
    <script src="vendor/alertify/alertify.min.js"></script>
    <script src="vendor/formvalidation/formvalidation.min.js"></script>
    <script src="vendor/formvalidation/framework/bootstrap4.min.js"></script>
    <script src="vendor/resources/js/estudiante.js"></script>
</body>

</html>