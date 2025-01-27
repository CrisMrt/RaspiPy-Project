<!DOCTYPE html>
<html>
<head>
    <title>Gráficos</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
</head>
<body>
    <div style="width: 600px;">
        <canvas id="cpuChart"></canvas>
    </div>

    <div style="width: 600px;">
        <canvas id="temperatureChart"></canvas>
    </div>

    <div style="width: 600px;">
        <canvas id="memoryChart"></canvas>
    </div>

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
</body>
</html>
