<?php session_start();
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>C|Mars</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@48,400,0,0" />
  <link rel="stylesheet" href="style.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <style>
        .chart-container {
  background-color: #fff;
  padding: 20px;
  margin-bottom: 20px;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
        </style>
</head>
<body>
   <div class="container">
      <aside>
         <div class="top">
           <div class="logo">
           <h2>R<span class="danger"><?php
             if(isset($_SESSION["adminNome"])){
             echo $_SESSION["adminNome"];} else{
                echo "Mars";
             } ?></span> </h2>
           </div>
           <div class="close" id="close_btn">
            <span class="material-symbols-sharp">
              close
              </span>
           </div>
         </div>
         
          <div class="sidebar">
           <a href="indexfinal.php" class="active">
              <span class="material-symbols-sharp">grid_view </span>
              <h3>Dados</h3>
           </a>
           <a href="graficos.php" class="active">
              <span class="material-symbols-sharp">insights </span>
              <h3>Gráficos</h3>
           </a>
           <a href="#">
              <span class="material-symbols-sharp">logout </span>
              <h3>logout</h3>
           </a>
          </div>
      </aside>

     
      
      <main>
      <h1>Gráficos</h1>
      <?php if (isset($_GET['selected_month'])) {
        $selected_month = $_GET['selected_month'];
        echo "<h2>" . $selected_month. "</h2>";
      }
      ?>
<div class="date">
<form method="GET" action="">
          <label for="selected_month">Selecione o mês:</label>
          <select name="selected_month" id="selected_month">
            <option value="01">Janeiro</option>
            <option value="02">Fevereiro</option>
            <option value="03">Março</option>
            <option value="04">Abril</option>
            <option value="05">Maio</option>
            <option value="06">Junho</option>
            <option value="07">Julho</option>
            <option value="08">Agosto</option>
            <option value="09">Setembro</option>
            <option value="10">Outubro</option>
            <option value="11">Novembro</option>
            <option value="12">Dezembro</option>
            </select>
          <input type="submit" value="Mostrar dados">
        </form>
</div>
      
<div class="chart-container">
<div style="width: 600px;">
        <canvas id="cpuChart"></canvas>
    </div>
</div>
      
<div class="chart-container">
<div style="width: 600px;">
        <canvas id="temperatureChart"></canvas>
    </div>
</div>
<div class="chart-container">
<div style="width: 600px;">
        <canvas id="memoryChart"></canvas>
    </div>
</div>
    

   

    <script src="script.js"></script>
    <script>
    <?php
    // Incluir o arquivo conexao2.php
    include 'conexao.php';
 
    

        if (isset($_GET['selected_month'])) {
            $selected_month = $_GET['selected_month'];
          
            $sql = "SELECT timestamp, cpu_usage, temperature, memory_usage FROM InformaçõesRPI WHERE DATE_FORMAT(timestamp, '%m') = '$selected_month' LIMIT 50";
            $result = $conn->query($sql);
          
             echo '// Separando os dados para cada métrica';

    $timestamps_data = array();
    $cpu_usage_data = array();
    $temperature_data = array();
    $memory_usage_data = array();


    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $timestamps_data[] = $row['timestamp'];
            $cpu_usage_data[] = $row['cpu_usage'];
            $temperature_data[] = $row['temperature'];
            $memory_usage_data[] = $row['memory_usage'];
        }
    }

    // Convertendo os arrays para o formato JSON
    $timestamps_json = json_encode($timestamps_data);
    $cpu_usage_json = json_encode($cpu_usage_data);
    $temperature_json = json_encode($temperature_data);
    $memory_usage_json = json_encode($memory_usage_data);
          }

    
    ?>
    </script>

    <script>
    // Criando gráficos com os dados obtidos
    var timestamps = <?php echo $timestamps_json; ?>;
    var cpuUsage = <?php echo $cpu_usage_json; ?>;
    var temperature = <?php echo $temperature_json; ?>;
    var memoryUsage = <?php echo $memory_usage_json; ?>;

    var cpuChartCtx = document.getElementById('cpuChart').getContext('2d');
    var temperatureChartCtx = document.getElementById('temperatureChart').getContext('2d');
    var memoryChartCtx = document.getElementById('memoryChart').getContext('2d');

    var cpuChart = new Chart(cpuChartCtx, {
        type: 'line',
        data: {
            labels: timestamps,
            datasets: [{
                label: 'CPU Usage',
                data: cpuUsage,
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        }
    });

    var temperatureChart = new Chart(temperatureChartCtx, {
        type: 'line',
        data: {
            labels: timestamps,
            datasets: [{
                label: 'Temperature',
                data: temperature,
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        }
    });

    var memoryChart = new Chart(memoryChartCtx, {
        type: 'line',
        data: {
            labels: timestamps,
            datasets: [{
                label: 'Memory Usage',
                data: memoryUsage,
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        }
    });
    </script>
      
      
      
</div>
</body>
</html>
