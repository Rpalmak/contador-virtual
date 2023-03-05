<?php
if(isset($_SESSION['usuario_sesion'])){
  include 'funciones/comprobar_conexion.php';
  // Consulta para sueldo
  $sql = "SELECT id, monto FROM sueldo WHERE id_usuario=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $id_usuario);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>Sueldo</td>";
    echo "<td>" . number_format($row['monto'], 0, ",", ".") . "</td>";
    echo "<td style='width: 50px; text-align: center;'><button type='button' class='btn btn-danger borrar_registro' id='".$row['id']."' onclick='borrarRegistro(\"".$row['id']."\")'>X</button></td>";
    echo "</tr>";
  }
  // Consulta para ingresos
  $sql = "SELECT id, nombre, monto FROM ingresos WHERE id_usuario=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $id_usuario);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['nombre'] . "</td>";
    echo "<td>" . number_format($row['monto'], 0, ",", ".") . "</td>";
    echo "<td style='width: 50px; text-align: center;'><button type='button' class='btn btn-danger borrar_registro' id='".$row['id']."' onclick='borrarRegistro(\"".$row['id']."\")'>X</button></td>";
    echo "</tr>";
  }

} else {
    echo "<script>alert('La sesión no está iniciada o id_usuario no está definido en la sesión');</script>";
}
?>
