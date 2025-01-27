<?php
// Add logs
function addLog($message) {
    $logFile = 'logs.txt';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "$timestamp - $message\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

// Usage
addLog('Camera server started');
addLog('Tirar foto!');
addLog('Foto tirada com sucesso!');
addLog('Erro ao tirar foto!');
?>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['takePhoto'])) {
    addLog('Tirar foto!');
    echo "<p>A tirar foto!</p>";
    $output = shell_exec('/home/pi/Desktop/tirarfoto.sh');
    if ($output) {
        addLog('Foto tirada com sucesso!');
    } else {
        addLog('Erro ao tirar foto!');
    }
    echo "<pre><h3>$output</h3></pre>";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?><?php
session_start();
include("conexao.php");
$output = shell_exec('python3 /var/www/html/teste/robot_websocket_server.py > /dev/null 2>&1 &');
$output = shell_exec('python3 /home/pi/Desktop/Object_Detection_Files/camerafinal1.py > /dev/null 2>&1 &');
echo "<pre><h3>Camera server started</h3></pre>";
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
  <script src="/socket.io/socket.io.js"></script>
  <style>
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .button a {
            text-decoration: none;
            color: #fff;
        }
        .controls {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }
        .controls-row {
            display: flex;
            gap: 10px;
        }
        .car-controls {
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .car-controls:hover {
            background-color: #0056b3;
        }
        .car-controls:active {
            background-color: #004085;
        }
        #control-stop {
            background-color: #dc3545;
        }
        #control-stop:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
   <div class="container">
      <aside>
         <div class="top">
           <div class="logo">
             <h2>R<span class="danger">
             Mars
            </span></h2>
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
           <a href="indexfinal.php" class="active">
              <span class="material-symbols-sharp">grid_view</span>
              <h3>Dados</h3>
           </a>
           <a href="graficos.php" class="active">
              <span class="material-symbols-sharp">insights</span>
              <h3>Gráficos</h3>
           </a>
          </div>
      </aside>
      
      <main>
      <h1>Câmera</h1>
      <img src="http://192.168.1.212:5000/video_feed" width="640" height="480">

      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['takePhoto'])) {
          echo "<p>A tirar foto!</p>";
          $output = shell_exec('/home/pi/Desktop/tirarfoto.sh');
          echo "<pre><h3>$output</h3></pre>";
          header("Location: " . $_SERVER['PHP_SELF']);
          exit;
      }
      ?>
      
        <form method="post" action="">
        </br> 
        <input type="hidden" name="takePhoto" value="true">
        <input type="submit" value="Tirar Fotografia" class="button">
        </form>

      <br>
      <a href="fotoresultado/exp/captured_image.jpg" download="captured_image.jpg" class ="button">
        Baixar Fotografia
      </a>

      <div class="controls">
        <button class="car-controls" id="control-forward" onmousedown="move('w')" onmouseup="move('stop')">W</button>
        <div class="controls-row">
            <button class="car-controls" id="control-left" onmousedown="move('a')" onmouseup="move('stop')">A</button>
            <button class="car-controls" id="control-stop" onclick="move('e')">Stop</button>
            <button class="car-controls" id="control-right" onmousedown="move('d')" onmouseup="move('stop')">D</button>
        </div>
        <button class="car-controls" id="control-backward" onmousedown="move('s')" onmouseup="move('stop')">S</button>
    </div>
      
   </main>

   <script>
     let socket = new WebSocket("ws://192.168.1.212:8765");

     socket.onopen = function(e) {
       console.log("[open] Connection established");
     };

     socket.onmessage = function(event) {
       console.log(`[message] Data received from server: ${event.data}`);
     };

     socket.onclose = function(event) {
       if (event.wasClean) {
         console.log(`[close] Connection closed cleanly, code=${event.code} reason=${event.reason}`);
       } else {
         console.error('[close] Connection died');
       }
     };

     socket.onerror = function(error) {
       console.error(`[error] ${error.message}`);
     };

     function move(direction) {
       if (socket.readyState === WebSocket.OPEN) {
         socket.send(direction);
       } else {
         console.error("WebSocket connection is not open");
       }
     }

     document.addEventListener('keydown', function(event) {
  switch(event.key) {
    case 'w':
      move('w');
      break;
    case 's':
      move('s');
      break;
    case 'a':
      move('d');
      break;
    case 'd':
      move('a');
      break;
  }
});

document.addEventListener('keyup', function(event) {
  switch(event.key) {
    case 'w':
    case 's':
    case 'a':
    case 'd':
      move('e');
      break;
  }
});
   </script>

<script>
     // Periodically update the data from the server
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
