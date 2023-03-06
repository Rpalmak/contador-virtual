<?php
   include 'funciones/comprobar_sesion.php';
   include 'funciones/comprobar_conexion.php';
   include 'totalIngresos.php';
  
   if (isset($_SESSION['mensaje'])) {
       echo "<script>alert('" . $_SESSION['mensaje'] . "');</script>";
       unset($_SESSION['mensaje']);
   }
   $meses = array(1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril", 5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto", 9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre");

$mesActual = mysqli_query($conn, "SELECT MONTH(NOW()) as mes");
$mesNumero = mysqli_fetch_assoc($mesActual);
$mesNombre = $meses[$mesNumero['mes']];

   ?>
<!DOCTYPE html>
<html lang="es">
   <html>
      <head>
         <meta name="viewport" content="width=device-width, user-scalable=no">
         <meta charset="utf-8" />
         <title>Contador Virtual</title>
         <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
         <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
         <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
         <link rel="stylesheet" type="text/css" href="Styles.css" />
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
         <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
      </head>
      <body>
         <header id="header">
            <div id="logo">
               <img src="assets/images/money_logo.png" class="app-logo" />
               <span id="brand">
               <strong>Contador</strong>Virtual </span>
            </div>
            <div class="center">
               <nav id="menu">
                  <ul>
                     <li>
                        <a href="bienvenida.php">Portal</a>
                     </li>
                     <li>
                        <a href="ingresos.php">Ingresos</a>
                     </li>
                     <li>
                        <a href="egresos.php">Egresos</a>
                     </li>
                     <li>
                     <a href="Presupuestos.php">Presupuestos</a>
                     </li>
                     <li>
                        <a href="Historico.html">Histórico</a>
                     </li>
                     <li>
                        <a href="funciones/cerrar_sesion.php" class="btn btn-danger">Cerrar sesión</a>
                     </li>
                  </ul>
               </nav>
            </div>
            <div class="clearfix"></div>
            </div>
         </header>
         <div class="container" id="main-content">
            <div class="row">
               <div class="col-md-2 text-center">
                  <form action="" method="POST">
                     <div class="form-group text-center">
                        <label for="sueldo"><b style="font-size: larger;">Sueldo</b></label><br>
                        <input type="number" class="form-control text-center" id="sueldo" name="sueldo">
                     </div>
                     <button type="submit" class="btn btn-primary w-100" onclick="ingresarSueldo()">Ingresar</button>
                  </form>
               </div>
               <div class="col-md-2 text-center">
                  <form action="" method="POST">
                     <div class="form-group">
                        <label for="otrosIngresos"><b style="font-size: larger;">Otros ingresos</b></label><br>
                        <label for="Nombre">Nombre:</label>
                        <input type="text" class="form-control text-center" id="nombre" name="nombre">
                        <label for="Monto">Monto:</label>
                        <input type="number" class="form-control text-center" id="monto" name="monto">
                     </div>
                     <button type="submit" class="btn btn-primary w-100" onclick="ingresarOtros(document.getElementById('monto').value, document.getElementById('nombre').value)">Ingresar</button>
                  </form>
               </div>
               <div class="col-md-4">
                  <div class="card" style="height: 300px; overflow-y: scroll;">
                  <div class="card-header" style="font-weight: bold;">Historial de ingresos</div>
                     <div class="card-body" style="padding: 0px;">
                        <table class="table table-striped table-bordered" style="height: auto; overflow-y: scroll;">
                           <thead>
                              <tr>
                                 <th>Nombre</th>
                                 <th>Monto</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                                include 'mostrar_saldo.php';
                                 ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <div class="col-md-4 text-center" style="height: 300px;">
                  <label for="sueldo"><b style="font-size: larger;">Total ingresos <?php echo $mesNombre; ?></b></label><br>
                  <label for="sueldo"><b style="font-size: larger;"><?php echo number_format($totalIngresos, 0, ",", "."); ?></b></label><br>
                  <canvas id="myChart"><?php include 'chartIngresosMes.php'; ?></canvas>
               </div>
            </div>
         </div>
         </div>
         </div>
         </div>
         <footer>
         </footer>
         <script>
  function showAlert(message) {
    alert(message);
  }

  function ingresarSueldo() {
  let sueldo = document.getElementById("sueldo").value;
  if (sueldo === "") {
    alert("Sueldo no está definido");
    return;
  }
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ingresarSueldo.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      let respuesta = JSON.parse(this.responseText);
      if (respuesta.status === "success") {
        alert("Nuevo registro creado exitosamente");
      } else {
        alert("Error: " + respuesta.error);
      }
    }
  };
  xhr.send("sueldo=" + sueldo);
}




  function ingresarOtros(monto, nombre) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ingresarOtros.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            let respuesta = JSON.parse(this.responseText);
            if (respuesta.status === "success") {
                alert("Nuevo registro creado exitosamente");
            } else {
                alert("Error: " + respuesta.error);
            }
        }
    };
    xhr.send("monto=" + monto + "&nombre=" + nombre);
}





            function borrarRegistro(id) {
              var monto = $(this).closest("tr").find("td:eq(1)").text();
              if (confirm("¿Está seguro de eliminar el registro?")) {
                $.ajax({
                  url: "deleteIngresos.php",
                  type: "POST",
                  data: { id: id },
                  success: function(data) {
                    location.reload();
                  }
                });
              }
            }
            $(document).ready(function() {
              $(".deleteIngresos").click(function() {
                var id = $(this).attr("id");
                borrarRegistro(id);
              });
            });
         </script>
      </body>
   </html>