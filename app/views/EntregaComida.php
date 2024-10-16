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
    <title>Entrega de Comida</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="vendor/jqgrid/ui.jqgrid.bootstrap5.css">
    <link rel="stylesheet" href="vendor/resources/css/dashboard.css">
    <link rel="stylesheet" href="vendor/alertify/alertify.min.css">
    <link rel="stylesheet" href="vendor/formvalidation/formvalidation.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body>
    <!-- Barra de navegación -->
    <?php include("Navbar.php");
    // Configurar la zona horaria
    date_default_timezone_set('America/El_Salvador');

    // Obtener la fecha y hora actual
    $fecha_entrega = date('Y-m-d H:i:s');
    $fecha_entrega = date('Y-m-d H:i:s');
    echo "fecha_entrega" . $fecha_entrega; ?>

    <main class="container mt-5">
        <div class="mb-4">
            <button class="btn btn-outline-primary me-2 mt-5" onclick="agregarEntrega()"><i
                    class="fa-solid fa-utensils"></i> Registrar Entrega</button>
            <button class="btn btn-outline-primary me-2 mt-5" onclick="eliminarEntrega()"><i
                    class="fa-solid fa-utensils"></i> Eliminar Entrega</button>
            <a href="/entregacomida/informetabla" target="_blank" class="btn btn-outline-primary me-2 mt-5">
                <i class="fa-solid fa-print"></i> Informe
            </a>
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
    <div class="container my-3">
        <div class="row">
            <div class="col-md-4">
                <label for="filtroFecha">Filtrar por Fecha:</label>
                <input type="date" id="filtroFecha" class="form-control" />
            </div>
        </div>
    </div>

    <div class="container">
        <table id="entregaComida"></table>
        <div id="navEntregaComida"></div>
    </div>

    <!-- Modal para entregar comida -->
    <div class="modal fade" id="modalEntregaComida" tabindex="-1" aria-labelledby="modalEntregaComidaLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEntregaComidaLabel">Registrar Entrega de Comida</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEntregaComida">
                    <div class="modal-body ">
                        <div class="row m-4">
                            <div class="col-sm-6">
                                <div class="form-group row ">
                                    <label for="comida" class="col-sm-12">Seleccionar Comida:</label>
                                    <select id="comida" class="col-sm-12 form-control" name="comida"
                                        class="form-control select2">
                                        <!-- Las opciones serán cargadas dinámicamente -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="estudiante" class="col-sm-12">Seleccionar Estudiante:</label>
                                    <select id="estudiante" class="col-sm-12 form-control" name="estudiante"
                                        class="form-control select2">
                                        <!-- Las opciones serán cargadas dinámicamente -->
                                    </select>
                                </div>
                            </div>
                            </di>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Registrar Entrega</button>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="vendor/resources/js/cargarSelect.js"></script>
    <script src="vendor/resources/js/entrega_comida.js"></script>
</body>

</html>