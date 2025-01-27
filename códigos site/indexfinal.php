<?php
session_start(); 
include("conexao.php"); 
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
</head>
<body>
   <div class="container">
      <aside>
         <div class="top">
           <div class="logo">
             <h2>R<span class="danger">Mars</span> </h2>
           </div>
         </div>
         
          <div class="sidebar">
          <a href="visualizacao.php" class="active">
              <span class="material-symbols-sharp">grid_view</span>
              <h3>Câmera</h3>
           </a>
           <a href="chat.php" class="active">
              <span class="material-symbols-sharp">grid_view</span>
              <h3>Chat</h3>
           </a>
           <a href="#" class="active">
              <span class="material-symbols-sharp">grid_view </span>
              <h3>Dados</h3>
           </a>
           <a href="graficos.php" class="active">
              <span class="material-symbols-sharp">insights </span>
              <h3>Gráficos</h3>
           </a>
          </div>
      </aside>
      
      <main>
      <h1>Dados</h1>
      <div class="date">
      <form method="get" action="">
       
        <label for="selected_date">Selecione a data:</label>
        <input type="date" id="selected_date" name="selected_date" value="<?php if(isset($selected_date)) { echo $selected_date; } ?>">
        <input type="submit" value="Visualizar">
        
      </form>
      
      <form method="get" action="">
            <button type="submit" name="dados_desde_inicio">Dados desde o início</button>
        </form>
        </div>
</br>
      <?php
        
        if(isset($_GET['dados_desde_inicio'])) {
            $sql = "SELECT COUNT(*) AS num_registros FROM InformaçõesRPI";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $num_registros = $row['num_registros'];
            echo "<h2> Total Registos desde o início: " .  $num_registros . "</h2>";
        } 

        if(isset($_GET['selected_date'])) {
            $selected_date = $_GET['selected_date'];
            $sql = "SELECT COUNT(*) AS num_registros FROM InformaçõesRPI WHERE DATE(timestamp) = '$selected_date'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $num_registros = $row['num_registros'];
            echo "<h2> Total Registos para " . $selected_date . ": " .  $num_registros . "</h2>";
        } 
      ?>
      

       
        <div class="insights">
    <div class="sales">
        <span class="material-symbols-sharp">trending_up</span>
        <div class="middle">
            <div class="left">
                <h3>Valor Uso Cpu Mais Alto:</h3>
                <?php
                $max_cpu_usage = "";
                if(isset($_GET['dados_desde_inicio'])) {
                    $sql = "SELECT MAX(cpu_usage) AS max_cpu_usage FROM InformaçõesRPI";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $max_cpu_usage = $row['max_cpu_usage'];
                } else if(isset($_GET['selected_date'])) {
                    $selected_date = $_GET['selected_date'];
                    $sql = "SELECT MAX(cpu_usage) AS max_cpu_usage FROM InformaçõesRPI WHERE DATE(timestamp) = '$selected_date'";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $max_cpu_usage = $row['max_cpu_usage'];
                }
                ?>
                <h1><?php echo number_format($max_cpu_usage, 0, ',', '.'); ?>%</h1>

            </div>
            <div class="progress">
            </div>
        </div>
    </div>
    
    <div class="expenses">
        <span class="material-symbols-sharp">local_mall</span>
        <div class="middle">
            <div class="left">
                <h3>Valor de Temperatura Mais Alta:</h3>
                <?php
                $max_temperature = "";
                if(isset($_GET['dados_desde_inicio'])) {
                    $sql = "SELECT MAX(temperature) AS max_temperature FROM InformaçõesRPI";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $max_temperature = $row['max_temperature'];
                } else if(isset($_GET['selected_date'])) {
                    $selected_date = $_GET['selected_date'];
                    $sql = "SELECT MAX(temperature) AS max_temperature FROM InformaçõesRPI WHERE DATE(timestamp) = '$selected_date'";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $max_temperature = $row['max_temperature'];
                }
                ?>
                <h1><?php echo number_format($max_temperature, 0, ',', '.'); ?>º</h1>

            </div>
            <div class="progress">
            </div>
        </div>
    </div>
    
    <div class="income">
        <span class="material-symbols-sharp">stacked_line_chart</span>
        <div class="middle">
            <div class="left">
                <h3>Valor de Uso de Memória Mais Alto:</h3>
                <?php
                $max_memory_usage = "";
                if(isset($_GET['dados_desde_inicio'])) {
                    $sql = "SELECT MAX(memory_usage) AS max_memory_usage FROM InformaçõesRPI";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $max_memory_usage = $row['max_memory_usage'];
                } else if(isset($_GET['selected_date'])) {
                    $selected_date = $_GET['selected_date'];
                    $sql = "SELECT MAX(memory_usage) AS max_memory_usage FROM InformaçõesRPI WHERE DATE(timestamp) = '$selected_date'";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $max_memory_usage = $row['max_memory_usage'];
                }
                ?>
                 <h1><?php echo number_format($max_memory_usage, 0, ',', '.'); ?>%</h1>

            </div>
            <div class="progress">
            </div>
        </div>
    </div>
    <div class="recent_order">
        <div style="width: 290px;">
        <canvas id="cpuChart"></canvas>
    </div>
        </div>
        <div class="recent_order">
        <div style="width: 290px;">
        <canvas id="temperatureChart"></canvas>
    </div>
        </div>
        <div class="recent_order">
        <div style="width: 290px;">
        <canvas id="memoryChart"></canvas>
    </div>
        </div>
        <script src="script.js"></script>
   <script>

    <?php
    if(isset($_GET['selected_date'])) {
        
        $selected_date = $_GET['selected_date'];
        $sql = "SELECT timestamp, cpu_usage, temperature, memory_usage FROM InformaçõesRPI WHERE DATE(timestamp) = '$selected_date' LIMIT 10";
        $result = $conn->query($sql);
        if ($result) {
            while($row = $result->fetch_assoc()) {
                $data[$formatted_date][] = $row;
            }
        } else {
             throw new Exception("Erro ao executar a consulta: " . $conn->error);
        }
        
    }
    $conn->close();
    echo '// Separando os dados para cada métrica';

    
    $timestamps_data = array();
    $cpu_usage_data = array();
    $temperature_data = array();
    $memory_usage_data = array();

     foreach ($data as $date => $metrics) {
        foreach ($metrics as $metric) {
            $timestamps_data[] = $metric['timestamp'];
            $cpu_usage_data[] = $metric['cpu_usage'];
            $temperature_data[] = $metric['temperature'];
            $memory_usage_data[] = $metric['memory_usage'];
        }
    }

     $timestamps_json = json_encode($timestamps_data);
    $cpu_usage_json = json_encode($cpu_usage_data);
    $temperature_json = json_encode($temperature_data);
    $memory_usage_json = json_encode($memory_usage_data);
    ?>
    </script>

    <script>
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
       

      </main>
      
    
</div>
<script>
     function carregarDadosAtualizados() {
       var xhr = new XMLHttpRequest();

       xhr.onreadystatechange = function() {
         if (xhr.readyState === XMLHttpRequest.DONE) {
           if (xhr.status === 200) {
              document.getElementById('dados-atualizados').innerHTML = xhr.responseText;
           } else {
              console.error('Erro ao carregar os dados: ' + xhr.status);
           }
         }
       };

       
       xhr.open('GET', 'index.php', true);

       xhr.send();
     }

     setInterval(carregarDadosAtualizados, 30000); // 30000 milissegundos = 30 segundos
   </script>
</body>
</html>
