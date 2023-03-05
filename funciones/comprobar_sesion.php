<?php
   if (!isset($_SESSION["usuario_sesion"])) {
       header("Location: Sesion.php");
   }
?>