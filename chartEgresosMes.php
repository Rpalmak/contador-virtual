<?php
  $sql1 = "SELECT categoria, SUM(monto) as monto FROM gastos GROUP BY categoria";
  $result1 = $conn->query($sql1);
  $labels = array();
  $data = array();
  $sum = 0;
  // Agregar valores de la tabla "gastos" agrupados por categoría y ordenados de mayor a menor
  while ($row1 = mysqli_fetch_assoc($result1)) {
    $labels[] = $row1['categoria'];
    $data[] = $row1['monto'];
    $sum += $row1['monto'];
  }
  array_multisort($data, SORT_DESC, $labels);
  echo json_encode(array('labels'=>$labels, 'data'=>$data, 'sum'=>$sum));
?>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: <?php echo json_encode($labels); ?>,
      datasets: [{
        data: <?php echo json_encode($data); ?>,
        backgroundColor: [
          'rgba(255, 99, 132)',
          'rgba(54, 162, 235)',
          'rgba(255, 206, 86)',
          'rgba(75, 192, 192)',
          'rgba(153, 102, 255)',
          'rgba(255, 159, 64)',
          'rgba(255, 99, 132)',
          'rgba(54, 162, 235)',
          'rgba(255, 206, 86)',
          'rgba(75, 192, 192)'
        ],
        borderColor: [
          'rgba(255, 99, 132)',
          'rgba(54, 162, 235)',
          'rgba(255, 206, 86)',
          'rgba(75, 192, 192)',
          'rgba(153, 102, 255)',
          'rgba(255, 159, 64)',
          'rgba(255, 99, 132)',
          'rgba(54, 162, 235)',
          'rgba(255, 206, 86)',
          'rgba(75, 192, 192)'
        ],
        borderWidth: 1
      }]
    },
    options: {
        legend: {
            display: true,
            position: 'bottom',
        },
      plugins: {
        datalabels: {
          
          display: 'auto',
          formatter: (value, context) => {
            let sum = <?php echo $sum; ?>;
            let percentage = (value*100 / sum).toFixed(2)+"%";
            return value + " (" + percentage + ")";
          },
        },
      },
    }
  });

</script>
