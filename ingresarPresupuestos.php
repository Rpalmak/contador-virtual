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

    if (!isset($_POST['monto'], $_POST['categoria'])) {
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
    $fecha = $_POST['fecha'];

    // Consulta para obtener monto total de la categoría correspondiente
    $sql_gasto = "SELECT COALESCE(SUM(monto), 0) AS total FROM gastos WHERE id_usuario = ? AND categoria = ? AND mes = ?";
    $stmt_gasto = $conn->prepare($sql_gasto);
    $stmt_gasto->bind_param("sss", $usuario_sesion, $categoria, $mes);
    $stmt_gasto->execute();
    $result_gasto = $stmt_gasto->get_result();
    $row_gasto = $result_gasto->fetch_assoc();
    $monto_usado = $row_gasto['total'];
    $monto_restante = $monto - $monto_usado;

    $sql = "INSERT INTO presupuestos (id_usuario, categoria, monto_total, monto_usado, monto_restante, mes) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiiis", $usuario_sesion, $categoria, $monto, $monto_usado, $monto_restante, $mes);
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
