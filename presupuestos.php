<?php
   include 'funciones/comprobar_sesion.php';
   include 'funciones/comprobar_conexion.php';
   include 'totalEgresos.php';
  
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
         <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
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
                        <a href="presupuestos.php">Presupuestos</a>
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
            <div class="col-md-4 text-center">
   <form action="" method="POST">
      <div class="form-group">
         <label for="otrosIngresos"><b style="font-size: larger;">Presupuesto mensual</b></label><br>
         <label for="categoria">Categoría:</label>
         <select class="form-control text-center" id="categoria" name="categoria">
            <option value="Supermercado">Supermercado</option>
            <option value="Salidas">Salidas</option>
            <option value="Comida">Comida</option>
            <option value="Regalos">Regalos</option>
            <option value="Entretenimiento">Entretenimiento</option>
            <option value="Deudas">Deudas</option>
            <option value="Salud">Salud</option>
            <option value="Transporte">Transporte</option>
            <option value="Tramites">Trámites</option>
         </select>
         <label for="Monto">Monto:</label>
         <input type="number" class="form-control text-center" id="monto" name="monto">
      </div>
      <button type="submit" class="btn btn-primary w-100" onclick="ingresarPresupuestos(document.getElementById('monto').value, document.getElementById('categoria').value)">Ingresar</button>
   </form>
</div>
               <div class="col-md-8">
                  <div class="card" style="height: 300px; overflow-y: scroll;">
                  <div class="card-header" style="font-weight: bold;">Presupuestos</div>
                     <div class="card-body" style="padding: 0px;">
                        <table class="table table-striped table-bordered" style="height: auto; overflow-y: scroll;border-spacing: 0;">
                           <thead>
                              <tr>
                                 <th>Categoría</th>
                                 <th>Monto Designado</th>
                                 <th>Monto Ocupado</th>
                                 <th>Monto Restante</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                                include 'mostrar_presupuestos.php';
                                 ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
            <div class="col-md-4 text-center" style="height: 300px;">
                  <label for="sueldo"><b style="font-size: larger;">Total gastos <?php echo $mesNombre; ?></b></label><br>
                  <label for="sueldo"><b style="font-size: larger;"><?php echo number_format($totalEgresos, 0, ",", "."); ?></b></label><br>
                  <canvas id="myChart" width="800" height="500"><?php include 'chartEgresosMes.php'; ?></canvas>
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


  function ingresarPresupuestos() {
   
    let monto = document.getElementById('monto').value;
    let categoria = document.getElementById('categoria').value;
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ingresarPresupuestos.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 200) {
                let respuesta = JSON.parse(this.responseText);
                if (respuesta.status === "success") {
                    alert("Nuevo registro creado exitosamente");
                } else {
                    alert("Error: " + respuesta.error);
                }
            } else {
                alert("Error: Se ha producido un error en la respuesta de la petición HTTP. Código de estado: " + this.status);
            }
        }
    };
    xhr.send("monto=" + monto + "&categoria=" + categoria);
}


            function borrarRegistro(id) {
              var monto = $(this).closest("tr").find("td:eq(1)").text();
              if (confirm("¿Está seguro de eliminar el registro?")) {
                $.ajax({
                  url: "deletePresupuestos.php",
                  type: "POST",
                  data: { id: id },
                  success: function(data) {
                    location.reload();
                  }
                });
              }
            }
            $(document).ready(function() {
              $(".deletePresupuestos").click(function() {
                var id = $(this).attr("id");
                borrarRegistro(id);
              });
            });
         </script>
      </body>
   </html>