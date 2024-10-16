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
    <title>Registro de Comida</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="vendor/jqgrid/ui.jqgrid.bootstrap5.css">
    <link rel="stylesheet" href="vendor/resources/css/dashboard.css">
    <link rel="stylesheet" href="vendor/alertify/alertify.min.css">
    <link rel="stylesheet" href="vendor/formvalidation/formvalidation.min.css">
</head>

<body>
    <?php include("Navbar.php"); ?>
    <main class="container mt-5">
        <div class="mb-4">
            <button class="btn btn-outline-primary me-2 mt-5" onclick="agregar()"><i class="fa-solid fa-plus"></i>
                Agregar</button>
            <button class="btn btn-outline-primary me-2 mt-5" onclick="editar()"><i class="fa-solid fa-pen"></i>
                Modificar</button>
            <button class="btn btn-outline-primary me-2 mt-5" onclick="eliminar()"><i class="fa-solid fa-trash-alt"></i>
                Eliminar</button>
            <a href="/registrocomida/informetabla" target="_blank" class="btn btn-outline-primary me-2 mt-5">
            <i class="fa-solid fa-print"></i> Informe
            </a>
        </div>
    </main>
    <div class="container my-3">
    <div class="row">
        <div class="col-md-4">
            <label for="fecha_inicio">Fecha de Inicio:</label>
            <input type="date" id="fecha_inicio" class="form-control">
        </div>
        <div class="col-md-4">
            <label for="fecha_fin">Fecha de Fin:</label>
            <input type="date" id="fecha_fin" class="form-control">
        </div>
    </div>
</div>
    <div class="container">
        <table id="registroComida"></table>
        <div id="navRegistroComida"></div>
    </div>

    <!-- Modal para agregar/editar comida -->
    <div class="modal fade" id="modalComida" tabindex="-1" aria-labelledby="modalComidaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalComidaLabel">Agregar/Editar Comida</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formComida">
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="id_comida" class="col-md-4 col-form-label">ID</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="id_comida" name="id_comida" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="nombre_platillo" class="col-md-4 col-form-label">Nombre del Platillo</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="nombre_platillo" name="nombre_platillo">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="tipo_comida" class="col-md-4 col-form-label">Tipo de Comida</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="tipo_comida" name="tipo_comida">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ingredientes" class="col-md-4 col-form-label">Ingredientes</label>
                            <div class="col-md-8">
                                <textarea class="form-control" id="ingredientes" name="ingredientes"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="porciones_preparadas" class="col-md-4 col-form-label">Porciones
                                Preparadas</label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" id="porciones_preparadas"
                                    name="porciones_preparadas">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="responsable" class="col-md-4 col-form-label">Responsable</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="responsable" name="responsable">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="fecha_preparacion" class="col-md-4 col-form-label">Fecha de Preparación</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" id="fecha_preparacion" name="fecha_preparacion">
                            </div>
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
    <script src="vendor/resources/js/registro_comida.js"></script>
</body>

</html>