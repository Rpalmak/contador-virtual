<?php
session_start();

if (!isset($_SESSION['usuario_sesion'])) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    include 'funciones/comprobar_conexion.php';

    $monto = $_POST['monto'];
    $nombre = $_POST['nombre'];

    if (empty($monto) || empty($nombre)) {
        $respuesta = array("status" => "error", "message" => "Debe ingresar valores en los campos monto y nombre");
        header('Content-Type: application/json');
        echo json_encode($respuesta);
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