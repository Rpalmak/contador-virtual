<?php
    session_start();
    $nombre = $_SESSION["usuario_sesion"];
?> 

<!DOCTYPE html> 
<html lang="es">
<html> 
<head> 
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <meta charset="utf-8" />
    <title>Contador Virtual</title>
    <!-- HOJA DE ESTILOS -->
    <link rel="stylesheet" type="text/css" href="Styles.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
        crossorigin="anonymous"></script>
</head>
<body>
    <header id="header">
        <div id="logo">
            <img src="assets/images/money_logo.png" class="app-logo" />
            <span id="brand">
                <strong>Contador</strong>Virtual
            </span>
        </div>
        <div class="center">
        <nav id="menu">
            <ul>
                <li>
                    <a href="bienvenida.php">Portal</a>
                </li>
                <li>
                    <a href="ingresos.php">Ingresos</a>
                </li>
                <li>
                    <a href="egresos.php">Egresos</a>
                </li>
                <li>
                    <a href="Presupuestos.php">Presupuestos</a>
                </li>
                <li>
                    <a href="Historico.html">Histórico</a>
                </li>
                <li>
                <a href="cerrar_sesion.php" class="btn btn-danger">Cerrar sesión</a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- limpiar flotados-->
    <div class="clearfix"></div>
    </div>
</header>
 <!-- Sección para mostrar información del usuario que ha iniciado sesión -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Información de la sesión</div>
                <div class="card-body">
    <p>Nombre de usuario: <?php echo $nombre; ?></p>
</div>

            </div>
        </div>
    </div>
</div>
<footer>
</footer>
</body>
</html>