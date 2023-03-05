<?php
session_start();
    // Conexión a la base de datos
    include 'funciones/comprobar_conexion.php';

    // Recibir valores del formulario de inicio de sesión
    $usuario = htmlspecialchars($_POST['usuario']);
    $password = htmlspecialchars($_POST['contraseña']);

    // Consulta para verificar si el usuario existe en la base de datos
    $sql = "SELECT * FROM Usuarios WHERE usuario=? AND contraseña=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $usuario, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $password_from_database = $row['contraseña'];
        if ($password == $password_from_database) {
            // Iniciar sesión y redirigir al usuario a la página principal
            $_SESSION['loggedin'] = true;
            $_SESSION['usuario_sesion'] = $_POST['usuario'];
            $_SESSION['id_usuario'] = $row['id_usuario'];
            header("Location: bienvenida.php");
            exit;
        } else {
            // Mostrar mensaje de error
            echo "<script>alert('El usuario o la contraseña son incorrectos.');
            history.back();
            </script>";
        }
    } else {
        // Mostrar mensaje de error
        echo "<script>alert('El usuario o la contraseña son incorrectos.');
        history.back();
        </script>";
    }
    $conn->close();
?>