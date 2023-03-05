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

  if (isset($_POST['sueldo']) === true) {
    $sueldo = $_POST['sueldo'];
    $id_usuario = $_SESSION['usuario_sesion'];
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

    $sql = "INSERT INTO sueldo (id_usuario, mes, monto) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $id_usuario, $mes, $sueldo);
    if ($stmt->execute()) {
      $respuesta = array("status" => "success", "message" => "Nuevo registro creado exitosamente");
    } else {
      $respuesta = array("status" => "error", "message" => "Error: " . $stmt->error);
    }
  } else {
    $respuesta = array("status" => "error", "message" => "Sueldo no está definido");
  }
  echo json_encode($respuesta);
  mysqli_close($conn);
}

?>