<?php
   session_start();
   if (!isset($_SESSION["usuario_sesion"])) {
       header("Location: sesion.php");
   }
?>