<?php
$servername = "192.168.1.212";
$database = "estatisticasraspberrypi";
$username = "papmaster";
$password = "password";

$conn = mysqli_connect($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$data = array();

// Obtém o primeiro dia do mês atual
$first_day_of_month = date('Y-m-01');

// Obtém o último dia do mês atual
$last_day_of_month = date('Y-m-t');

// Itera sobre os dias do mês atual
$current_date = $first_day_of_month;
while ($current_date <= $last_day_of_month) {
    // Formata a data atual para usar na consulta SQL
    $formatted_date = date('Y-m-d', strtotime($current_date));
    
    $sql = "SELECT timestamp, cpu_usage, temperature, memory_usage FROM InformaçõesRPI WHERE DATE(timestamp) = '$formatted_date' LIMIT 5";
    
    $result = $conn->query($sql);
    
    if ($result) {
        while($row = $result->fetch_assoc()) {
            $data[$formatted_date][] = $row;
        }
    } else {
        throw new Exception("Erro ao executar a consulta: " . $conn->error);
    }
    
    // Avança para o próximo dia
    $current_date = date('Y-m-d', strtotime($current_date . ' +1 day'));
}

$conn->close();
