<?php
if(isset($_SESSION['usuario_sesion'])){
  include 'comprobar_conexion.php';
  // Consulta para gastos
  $sql = "SELECT id, fecha, categoria, comentario, monto  FROM gastos WHERE id_usuario=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $id_usuario);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td style='width: fit-content;'>" . $row['categoria'] . "</td>";
    echo "<td>" . $row['comentario'] . "</td>";
    echo "<td>" . number_format($row['monto'], 0, ",", ".") . "</td>";
    echo "<td>" . $row['fecha'] . "</td>";
    echo "<td style='width: 50px; text-align: center;'><button type='button' class='btn btn-danger borrar_registro' id='".$row['id']."' onclick='borrarRegistro(\"".$row['id']."\")'>X</button></td>";
    echo "</tr>";
  }
} else {
    echo "<script>alert('La sesión no está iniciada o id_usuario no está definido en la sesión');</script>";
}
?>
