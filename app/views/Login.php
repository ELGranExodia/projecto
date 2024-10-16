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
    <title>Comedor</title>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/resources/css/home.css">
</head>

<body class="vh-100 bg-secondary d-flex justify-content-center align-items-center">
    <div class="card px-4" style="max-width: 400px; width: 100%;">
        <div class="card-body">
            <form id="formLogin">
                <h3 class="text-center mb-3">SISTEMA DE CONTROL<br>DE COMEDOR</h3>
                <h4 class="text-center mb-3">INICIO DE SESIÓN</h4>
                <div class="mb-3">
                    <label for="user">Usuario:</label>
                    <input type="text" id="user" name="user" class="form-control">
                    <div class="invalid-feedback">
                        Usuario incorrecto
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" class="form-control">
                    <div class="invalid-feedback">
                        Contraseña incorrecta
                    </div>
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-light fw-bold">INGRESAR</button>
                </div>
            </form>
        </div>
    </div>

    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery/jquery.js"></script>
    <script src="vendor/resources/js/login.js"></script>
</body>

</html>