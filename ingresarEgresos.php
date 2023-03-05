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

    if (!isset($_POST['monto'], $_POST['categoria'], $_POST['comentario'],$_POST['fecha'])) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }

    // Validation para monto
    if (!is_numeric($_POST['monto']) || $_POST['monto'] <= 0) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }

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
    $monto = $_POST['monto'];
    $categoria = $_POST['categoria'];
    $comentario = $_POST['comentario'];
    $fecha = $_POST['fecha'];
    $sql = "INSERT INTO gastos (fecha, mes, id_usuario, categoria, comentario, monto) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $fecha, $mes, $usuario_sesion, $categoria, $comentario, $monto);
    if ($stmt->execute()) {
        $respuesta = array("status" => "success", "message" => "Nuevo registro creado exitosamente");
    } else {
        $respuesta = array("status" => "error", "message" => "Error: " . $stmt->error);
    }


$sql_update = "UPDATE presupuestos SET monto_usado = monto_usado + $monto, monto_restante = monto_total - monto_usado WHERE id_usuario = ? AND categoria = ?";
$stmt_update = $conn->prepare($sql_update);
$stmt_update->bind_param("is", $usuario_sesion, $categoria);
if ($stmt_update->execute()) {
$respuesta = array("status" => "success", "message" => "Nuevo registro creado y monto actualizado exitosamente");
} else {
$respuesta = array("status" => "error", "message" => "Error: " . $stmt_update->error);
}


    mysqli_close($conn);
    header('Content-Type: application/json');
    echo json_encode($respuesta);
}
?>
