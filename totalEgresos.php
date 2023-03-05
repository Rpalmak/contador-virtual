<?php
if(isset($_SESSION['usuario_sesion'])){
    include 'comprobar_conexion.php';
  
    $id_usuario = $_SESSION["usuario_sesion"];
    
    $totalEgresos = 0;
  
    $sql = "SELECT SUM(monto) as total FROM gastos WHERE id_usuario=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = mysqli_fetch_assoc($result)) {
        $totalEgresos += $row['total'];
    }
  } else {
      echo "<script>alert('La sesión no está iniciada o id_usuario no está definido en la sesión');</script>";
  }
  
?>