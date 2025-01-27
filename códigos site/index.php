<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Style for the video container */
        #video-container {
            width: 640px; /* Adjust the width as needed */
            height: 480px; /* Adjust the height as needed */
            margin: 0 auto; /* Center the container horizontally */
            overflow: hidden; /* Hide any overflow content */
            border: 1px solid #ccc; /* Optional: Add a border around the container */
        }
        </style>

    <script>
        function atualizarPagina() {
            location.reload();
        }

        setInterval(atualizarPagina, 150000);
        </script>

        
    

</head>
<body>

<!--<div id="video-container">
        <!-- Video element to display live stream -->
       <!-- <video id="live-stream"></video>
    </div>-->

    <h1>Raspberry Pi Information</h1>
    <?php
    $output = shell_exec('node teste.js');

    
    echo "<pre><h3>$output<h3></pre>";
    ?>
    <?php
    



    
        $conn = new mysqli('192.168.1.212', 'papmaster', 'password', 'estatisticasraspberrypi');
        
        if ($conn->connect_error) {
    
         die("Erro na conexão com o banco de dados: " . $conn->connect_error);
        }
        else{
            
        $output = shell_exec('node informacoes.js');
        $parts = explode(",", $output);
        $memoryUsage = $parts[0]; 
        $cpuUsage = $parts[1]; 
        $cpuTemperature = $parts[2]; 
        
        $sql = "INSERT INTO InformaçõesRPI (memory_usage, cpu_usage, temperature) VALUES ('$memoryUsage', '$cpuUsage', '$cpuTemperature')";

        if ($conn->query($sql) === TRUE) {
            echo "Informações inseridas no banco de dados com sucesso!";
        } else {
            echo "Erro ao inserir informações no banco de dados: " . $conn->error;
        }
    
        $conn->close();
        }   
    



?>
</body>


</html>
