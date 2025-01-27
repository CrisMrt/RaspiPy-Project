<?php include("conexao.php"); ?>
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
             <h2>C<span class="danger">Mars</span> </h2>
           </div>
           <div class="close" id="close_btn">
            <span class="material-symbols-sharp">
              close
              </span>
           </div>
         </div>
         <!-- end top -->
          <div class="sidebar">

            
           <a href="#" class="active">
              <span class="material-symbols-sharp">insights </span>
              <h3>Dados</h3>
           </a>
           
           <a href="#">
              <span class="material-symbols-sharp">logout </span>
              <h3>logout</h3>
           </a>
             


          </div>

      </aside>
     

      <main>
      <?php
                   $sql = "SELECT COUNT(*) AS num_registros FROM InformaçõesRPI";
                   $result = $conn->query($sql);
                   $row = $result->fetch_assoc();
                   $num_registros = $row['num_registros'];
                   ?>

           <h1>Dados   <?php echo "<h2> Total Registos: " .  $num_registros . "</h2>" ?></h1>

          

        <div class="insights">

           <!-- start seling -->
            <div class="sales">
               <span class="material-symbols-sharp">trending_up</span>
               <div class="middle">

                 <div class="left">
                   <h3>Valor Uso Cpu Mais Alto:</h3>
                   <?php
                    $sql = "SELECT MAX(cpu_usage) AS max_cpu_usage FROM InformaçõesRPI";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $max_cpu_usage = $row['max_cpu_usage'];
                   ?>
                   <h1><?php echo $max_cpu_usage; ?></h1>
                 </div>
                  <div class="progress">
                      
                  </div>

               </div>
               
            </div>
           <!-- end seling -->
              <!-- start expenses -->
              <div class="expenses">
                <span class="material-symbols-sharp">local_mall</span>
                <div class="middle">
 
                  <div class="left">
                    <h3>Valor de Temperatura Mais Alta:</h3>
                    <?php
                   $sql = "SELECT MAX(temperature) AS max_temperature FROM InformaçõesRPI";
                   $result = $conn->query($sql);
                   $row = $result->fetch_assoc();
                   $max_temperature = $row['max_temperature'];
                   ?>
                   <h1><?php echo $max_temperature;  ?></h1>
                  </div>
                   <div class="progress">
                      
                       
                   </div>
 
                </div>
                
             </div>
            <!-- end seling -->
               <!-- start seling -->
               <div class="income">
                <span class="material-symbols-sharp">stacked_line_chart</span>
                <div class="middle">
 
                  <div class="left">
                    <h3>Valor de Uso de Memória Mais Alto:</h3>
                    <?php
                    $sql = "SELECT MAX(memory_usage) AS max_memory_usage FROM InformaçõesRPI";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $max_memory_usage = $row['max_memory_usage'];
                   ?>
                   <h1><?php echo $max_memory_usage;  ?></h1>
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

        
        
          
        </div>
       

      </main>

     
     
    


   <script src="script.js"></script>
   <script>
    <?php
    // Incluir o arquivo conexao2.php
    include 'conexao2.php';

    // Separar os dados para cada métrica
    echo '// Separando os dados para cada métrica';

    // Inicializar arrays vazios para armazenar os dados de cada métrica
    $timestamps_data = array();
    $cpu_usage_data = array();
    $temperature_data = array();
    $memory_usage_data = array();

    // Iterar sobre os dados e separá-los para cada métrica
    foreach ($data as $date => $metrics) {
        foreach ($metrics as $metric) {
            $timestamps_data[] = $metric['timestamp'];
            $cpu_usage_data[] = $metric['cpu_usage'];
            $temperature_data[] = $metric['temperature'];
            $memory_usage_data[] = $metric['memory_usage'];
        }
    }

    // Convertendo os arrays para o formato JSON
    $timestamps_json = json_encode($timestamps_data);
    $cpu_usage_json = json_encode($cpu_usage_data);
    $temperature_json = json_encode($temperature_data);
    $memory_usage_json = json_encode($memory_usage_data);
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
    },
    options: {
        scales: {
            y: {
                ticks: {
                    min: Math.min(...cpuUsage),
                    max: Math.max(...cpuUsage),
                    stepSize: Math.max(...cpuUsage) - Math.min(...cpuUsage),
                    callback: function(value, index, values) {
                        if (value === this.min || value === this.max) {
                            return value;
                        } else {
                            return '';
                        }
                    }
                }
            },
            x: {
                ticks: {
                    callback: function(value, index, values) {
                        if (index === 0 || index === values.length - 1) {
                            return value;
                        } else {
                            return '';
                        }
                    }
                }
            }
        }
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
    },
    options: {
        scales: {
            y: {
                ticks: {
                    min: Math.min(...temperature),
                    max: Math.max(...temperature),
                    stepSize: Math.max(...temperature) - Math.min(...temperature),
                    callback: function(value, index, values) {
                        if (value === this.min || value === this.max) {
                            return value;
                        } else {
                            return '';
                        }
                    }
                }
            }
        }
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
    },
    options: {
        scales: {
            y: {
                ticks: {
                    min: Math.min(...memoryUsage),
                    max: Math.max(...memoryUsage),
                    stepSize: Math.max(...memoryUsage) - Math.min(...memoryUsage),
                    callback: function(value, index, values) {
                        if (value === this.min || value === this.max) {
                            return value;
                        } else {
                            return '';
                        }
                    }
                }
            }
        }
    }
});

    </script>
</body>
</html>
