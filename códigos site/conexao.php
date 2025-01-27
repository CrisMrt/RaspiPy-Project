<?php
$servername = "192.168.1.212";
$database = "estatisticasraspberrypi";
$username = "papmaster";
$password = "password";

$conn = mysqli_connect($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

?>