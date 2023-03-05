<?php
if(isset($_POST["id"])) {
  $id = $_POST["id"];
  include 'funciones/comprobar_conexion.php';
  // Consulta para obtener información del gasto eliminado
  $sql_gasto = "SELECT * FROM gastos WHERE id=?";
  $stmt_gasto = $conn->prepare($sql_gasto);
  $stmt_gasto->bind_param("s", $id);
  $stmt_gasto->execute();
  $result_gasto = $stmt_gasto->get_result();
  $row_gasto = $result_gasto->fetch_assoc();
  $categoria = $row_gasto['categoria'];
  $monto = $row_gasto['monto'];
  $usuario_sesion = $row_gasto['id_usuario'];

  // Eliminar el gasto
  $sql_eliminar = "DELETE FROM gastos WHERE id=?";
  $stmt_eliminar = $conn->prepare($sql_eliminar);
  $stmt_eliminar->bind_param("s", $id);
  $stmt_eliminar->execute();

  // Actualizar la tabla presupuestos
  $sql_update = "UPDATE presupuestos SET monto_usado = monto_usado - ?, monto_restante = monto_total - monto_usado WHERE id_usuario = ? AND categoria = ?";
  $stmt_update = $conn->prepare($sql_update);
  $stmt_update->bind_param("iss", $monto, $usuario_sesion, $categoria);
  if ($stmt_update->execute()) {
      $respuesta = array("status" => "success", "message" => "Gasto eliminado y presupuesto actualizado exitosamente");
  } else {
      $respuesta = array("status" => "error", "message" => "Error: " . $stmt_update->error);
  }

  mysqli_close($conn);
}

?>
