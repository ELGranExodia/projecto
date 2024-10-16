<?php

    // Importamos la clase Route
    use App\Core\Route;

    // Importamos la clase de nuestro controlador HomeController
    use App\Controllers\LoginController;
    use App\Controllers\DashboardController;
    use App\Controllers\ProveedorController;
    use App\Controllers\MenuController;
    use App\Controllers\DesayunosController;
    use App\Controllers\EstudianteController;
    use App\Controllers\RegistroComidaController;
    use App\Controllers\EntregaComidaController;

    // Establecemos las rutas de nuestra aplicación
    Route::get('/', [LoginController::class, 'index']);
    Route::get('menu', [MenuController::class, 'index']);
    Route::get('desayunos', [DesayunosController::class, 'index']);
    Route::post('login/verify', [LoginController::class, 'verify']);

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/proveedores', [ProveedorController::class, 'index']);
    Route::post('proveedores/obtener_proveedores', [ProveedorController::class, 'obtener_proveedores']);
    Route::post('proveedores/guardar', [ProveedorController::class, 'guardar']);
    Route::post('proveedores/editar', [ProveedorController::class, 'editar']);
    Route::post('proveedores/eliminar', [ProveedorController::class, 'eliminar']);
    Route::post('proveedores/verificarNrc', [ProveedorController::class, 'verificarNrc']);
    Route::get('proveedores/informe', [ProveedorController::class, 'informe']);
    Route::get('proveedores/informetabla', [ProveedorController::class, 'informetabla']);

    
    Route::get('/estudiantes', [EstudianteController::class, 'index']);
    Route::post('estudiantes/obtener_estudiantes', [EstudianteController::class, 'obtener_estudiantes']);
    Route::post('estudiantes/guardar', [EstudianteController::class, 'guardar']);
    Route::post('estudiantes/editar', [EstudianteController::class, 'editar']);
    Route::post('estudiantes/eliminar', [EstudianteController::class, 'eliminar']);
    Route::post('estudiantes/verificarNie', [EstudianteController::class, 'verificarNie']);
    Route::get('estudiantes/informetabla', [EstudianteController::class, 'informetabla']);
    Route::post('estudiantes/obtener_listaestudiantes', [EstudianteController::class, 'obtener_listaestudiantes']);
    Route::post('estudiantes/obtenerFiltros', [EstudianteController::class, 'obtenerFiltros']);

    Route::get('/registrocomida', [RegistroComidaController::class, 'index']);
    Route::post('registrocomida/obtener_registro', [RegistroComidaController::class, 'obtener_registro']);
    Route::post('registrocomida/guardar', [RegistroComidaController::class, 'guardar']);
    Route::post('registrocomida/editar', [RegistroComidaController::class, 'editar']);
    Route::post('registrocomida/eliminar', [RegistroComidaController::class, 'eliminar']);
    Route::post('registrocomida/verificarPlatillo', [RegistroComidaController::class, 'verificarPlatillo']);
    Route::get('registrocomida/informetabla', [RegistroComidaController::class, 'informetabla']);
    Route::post('registrocomida/obtener_listacomidas', [RegistroComidaController::class, 'obtener_listacomidas']);
    Route::post('registrocomida/filtrar_por_fecha', [RegistroComidaController::class, 'filtrar_por_fecha']);

    Route::get('/entregacomida', [EntregaComidaController::class, 'index']);
    Route::post('entregacomida/obtener_registro', [EntregaComidaController::class, 'obtener_registro']);
    Route::post('entregacomida/guardar', [EntregaComidaController::class, 'guardar']);
    Route::post('entregacomida/eliminar', [EntregaComidaController::class, 'eliminar']);
    Route::get('entregacomida/informetabla', [EntregaComidaController::class, 'informetabla']);

    // Ejecutamos el método para mapear nuestra ruta
    Route::dispatch();
