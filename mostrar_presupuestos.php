<?php
if(isset($_SESSION['usuario_sesion'])){
  include 'comprobar_conexion.php';
  // Consulta para gastos
  $sql = "SELECT id, categoria, monto_total, monto_usado, monto_restante  FROM presupuestos WHERE id_usuario=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $id_usuario);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td style='width: fit-content;'>" . $row['categoria'] . "</td>";
    echo "<td>" . number_format($row['monto_total'], 0, ",", ".") . "</td>";
    echo "<td>" . number_format($row['monto_usado'], 0, ",", ".") . "</td>";
    echo "<td class='";
    if ($row['monto_restante'] > 0) {
      echo "verde";
    } else {
      echo "rojo";
    }
    echo "'>" . number_format($row['monto_restante'], 0, ",", ".") . "</td>";
    echo "<td style='width: 50px; text-align: center;'><button type='button' class='btn btn-danger borrar_registro' id='".$row['id']."' onclick='borrarRegistro(\"".$row['id']."\")'>X</button></td>";
    echo "</tr>";
  }

} else {
    echo "<script>alert('La sesión no está iniciada o id_usuario no está definido en la sesión');</script>";
}
?>
