<?php
if(isset($_SESSION['usuario_sesion'])){
    include 'funciones/comprobar_conexion.php';
  
    $id_usuario = $_SESSION["usuario_sesion"];
    
    $totalIngresos = 0;
  
    // Consulta para sueldo
    $sql = "SELECT SUM(monto) as total FROM sueldo WHERE id_usuario=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = mysqli_fetch_assoc($result)) {
        $totalIngresos += $row['total'];
    }
  
    // Consulta para ingresos
    $sql = "SELECT SUM(monto) as total FROM ingresos WHERE id_usuario=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = mysqli_fetch_assoc($result)) {
        $totalIngresos += $row['total'];
    }
  
  } else {
      echo "<script>alert('La sesión no está iniciada o id_usuario no está definido en la sesión');</script>";
  }
  
?>