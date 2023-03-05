<?php
session_start();

if (!isset($_SESSION['usuario_sesion'])) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    $host = "localhost";
    $username = "contador";
    $password = "123456";
    $dbname = "contadorvirtual";
    $conn = mysqli_connect($host, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (!isset($_POST['monto'], $_POST['nombre'])) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }

    $monto = $_POST['monto'];
    $usuario_sesion = $_SESSION['usuario_sesion'];
    $mes = date('F');
    $meses = array(
        'January' => 'Enero',
        'February' => 'Febrero',
        'March' => 'Marzo',
        'April' => 'Abril',
        'May' => 'Mayo',
        'June' => 'Junio',
        'July' => 'Julio',
        'August' => 'Agosto',
        'September' => 'Septiembre',
        'October' => 'Octubre',
        'November' => 'Noviembre',
        'December' => 'Diciembre'
    );
    $mes = $meses[$mes];
    $nombre = $_POST['nombre'];
    $fecha = date('Y-m-d H:i:s');
    $sql = "INSERT INTO ingresos (fecha, id_usuario, nombre, monto, mes) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssds", $fecha, $usuario_sesion, $nombre, $monto, $mes);
    if ($stmt->execute()) {
        $respuesta = array("status" => "success", "message" => "Nuevo registro creado exitosamente");
    } else {
        $respuesta = array("status" => "error", "message" => "Error: " . $stmt->error);
    }

    mysqli_close($conn);
    header('Content-Type: application/json');
    echo json_encode($respuesta);
}
?>