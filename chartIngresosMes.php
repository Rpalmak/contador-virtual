<?php
  // Obtener valores de la tabla "ingresos"
  $sql1 = "SELECT nombre, monto FROM ingresos";
  $result1 = $conn->query($sql1);

  // Obtener valores de la tabla "sueldo"
  $sql2 = "SELECT monto FROM sueldo";
  $result2 = $conn->query($sql2);

  $labels = array();
  $data = array();

  // Agregar valores de la tabla "ingresos"
  while ($row1 = mysqli_fetch_assoc($result1)) {
    $labels[] = $row1['nombre'];
    $data[] = $row1['monto'];
  }

  // Agregar valores de la tabla "sueldo"
  while ($row2 = mysqli_fetch_assoc($result2)) {
    $labels[] = 'Sueldo';
    $data[] = $row2['monto'];
  }

  echo json_encode(array('labels'=>$labels, 'data'=>$data));
?>


<script>
  // Crear el gráfico
  var ctx = document.getElementById('myChart').getContext('2d');
  document.getElementById('myChart').width = 800;
  document.getElementById('myChart').height = 500;
  var myChart = new Chart(ctx, {
      type: 'pie',
      data: {
          labels: <?php echo json_encode($labels); ?>,
          datasets: [{
              data: <?php echo json_encode($data); ?>,
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)',
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)'
              ],
              borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)',
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)'
              ],
              borderWidth: 1
          }]
      },
      options: {
      }
  });
</script>

