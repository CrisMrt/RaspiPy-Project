<?php include("conexao.php"); ?>
<html>
<head>
    <title>Página Inicial</title>
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            row-gap: 50px;
            column-gap: 50px;
        }
        .grid-item {
            padding: 20px;
            text-align: center;
            border: 3px solid rgba(0,0,0,0.8);
        }
        /* Cores personalizadas para cada container */
        .cor-vermelha {
            background-color: #ff9999; /* Vermelho */
            
        }
        .cor-verde {
            background-color: #99ff99; /* Verde */
        }
        .cor-azul {
            background-color: #99ccff; /* Azul */
        }
        .cor-amarela {
            background-color: #ffff99; /* Amarelo */
        }
    </style>
</head>
<body>
    <h1>Informações da Base de Dados</h1>
    <div class="grid-container">
        <?php
        // Consultar o número de registros na base de dados
        $sql = "SELECT COUNT(*) AS num_registros FROM InformaçõesRPI";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $num_registros = $row['num_registros'];
        echo '<div class="grid-item cor-vermelha">Número de Registros: ' . '<br>' .  $num_registros . '</div>';

        // Consultar o valor de uso do CPU mais alto
        $sql = "SELECT MAX(cpu_usage) AS max_cpu_usage FROM InformaçõesRPI";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $max_cpu_usage = $row['max_cpu_usage'];
        echo '<div class="grid-item cor-verde">Valor de Uso do CPU Mais Alto: ' . '<br>' .  $max_cpu_usage . '</div>';

        // Consultar o valor de uso de memória mais alto
        $sql = "SELECT MAX(memory_usage) AS max_memory_usage FROM InformaçõesRPI";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $max_memory_usage = $row['max_memory_usage'];
        echo '<div class="grid-item cor-azul">Valor de Uso de Memória Mais Alto: ' . '<br>' .  $max_memory_usage . '</div>';

        // Consultar a temperatura mais alta obtida entre todos os registros
        $sql = "SELECT MAX(temperature) AS max_temperature FROM InformaçõesRPI";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $max_temperature = $row['max_temperature'];
        echo '<div class="grid-item cor-amarela">Temperatura Mais Alta Obtida: ' . '<br>' .  $max_temperature . '</div>';

        // Fechar a conexão com o banco de dados
        $conn->close();
        ?>
    </div>
</body>
</html>
