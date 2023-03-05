<?php
if (isset($_POST["enviar"]) )
{
    session_start();
    $_SESSION["usuario"] = htmlentities($_POST["usuario"]);
    header("Location: bienvenida.php");
}
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
                        <a href="Sesion.html">Iniciar sesion</a>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- limpiar flotados-->
        <div class="clearfix"></div>
        </div>
    </header>
    <div class="container" id="main-content">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <form action="validar_sesion.php" method="post">
                    <div class="form-group">
                        <label for="usuario">Usuario</label>
                        <input type="text" name="usuario" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="contraseña">Contraseña</label>
                        <input type="password" name="contraseña" class="form-control">
                    </div>
                    <div class="form--group">
                        <input type="submit" value="Entrar" class="btn btn-primary">
                        <input type="button" value="Test" class="btn btn-success" onclick="comprobarConexion()">
                    </div>
                </form
>
            </div>
        </div>
    </div>
    <script>
        function comprobarConexion() {
            fetch('comprobar_conexion.php', {method: 'get'})
                .then(response => response.text())
                .then(data => {
                    if(data == 'success') {
                        alert('Conexión exitosa');
                    } else {
                        alert('Conexión fallida');
                    }
                });
        }
    </script>
    <footer>
    </footer>
</body>
</html>