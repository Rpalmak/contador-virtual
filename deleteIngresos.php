<?php
  if(isset($_POST["id"])) {
    $id = $_POST["id"];
    $host = "localhost";
    $username = "contador";
    $password = "123456";
    $dbname = "contadorvirtual";
    $conn = mysqli_connect($host, $username, $password, $dbname);

    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

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
