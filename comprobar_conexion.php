<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$servername = "localhost";
$username = "contador";
$password = "123456";
$dbname = "contadorvirtual";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    $conn_result = 'failed';
} else {
    $conn_result = 'success';
}
?>
