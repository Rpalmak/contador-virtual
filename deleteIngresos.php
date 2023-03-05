<?php
  if(isset($_POST["id"])) {
    $id = $_POST["id"];
    include 'funciones/comprobar_conexion.php';
    $sql = "DELETE FROM sueldo WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $sql = "DELETE FROM ingresos WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    mysqli_close($conn);
  }
?>
