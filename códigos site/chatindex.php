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
  <style>
    /* Estilos para o chat */
.chat {
  margin-top: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  overflow: hidden;
}

.message {
  padding: 10px;
  background-color: #f9f9f9;
}

.message .sender {
  font-weight: bold;
  color: #555;
}

.message .text {
  margin-top: 5px;
}

.button {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 6px 12px;
  gap: 8px;
  height: 40px;
  width: 114px;
  border: none;
  background: #1b1b1cde;
  border-radius: 20px;
  cursor: pointer;
}

.lable {
  line-height: 20px;
  font-size: 17px;
  color: #FF342B;
  font-family: sans-serif;
  letter-spacing: 1px;
}

.button:hover {
  background: #1b1b1c;
}

.button:hover .svg-icon {
  animation: scale 1s linear infinite;
}

@keyframes scale {
  0% {
    transform: scale(1);
  }

  50% {
    transform: scale(1.05) rotate(10deg);
  }

  100% {
    transform: scale(1);
  }
}

  </style>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
           <a href="logout.php">
              <span class="material-symbols-sharp">logout </span>
              <h3>logout</h3>
           </a>
          </div>
      </aside>
      
      <main>
        <h2>Enviar Arquivo de Áudio</h2>

        <form method="post" action="">
    <button type="submit" name="startRecording" value="true" style="background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    transition-duration: 0.4s;
    cursor: pointer;
    border-radius: 10px;">Start Recording</button>
</form>


  <?php
if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
    if (isset($_POST['startRecording'])) {
    echo "<p>Recording started!</p>";
   $output = shell_exec('/home/pi/Desktop/bash_script.sh');
   echo "<pre><h3>$output</h3></pre>";
    }
}
?>

        
       
   

<?php
// Caminho do arquivo de áudio
$audioFilePath = 'conseguiste.wav';

// Verifica se o arquivo existe
if (!file_exists($audioFilePath)) {
    echo "Error: Audio file not found.";
    exit;
}

// Inicializa CURL para a primeira API
$curl1 = curl_init();

// Configurações do CURL para a primeira API
curl_setopt_array($curl1, [
    CURLOPT_URL => "https://chatgpt-42.p.rapidapi.com/whisperv3?language=pt-PT", // Define o idioma como pt-PT
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => [
        'file' => curl_file_create($audioFilePath, 'audio/wav', 'conseguiste.wav')
    ],
    CURLOPT_HTTPHEADER => [
        "x-rapidapi-host: chatgpt-42.p.rapidapi.com",
        "x-rapidapi-key: 2faab0b5cbmsh5bea04cf7aff801p17d954jsnf01dd3820fff"
    ],
]);

// Executa a requisição CURL para a primeira API
$response1 = curl_exec($curl1);
$err1 = curl_error($curl1);

// Fecha o CURL para a primeira API
curl_close($curl1);

// Verifica erros no CURL para a primeira API
if ($err1) {
    echo "cURL Error #:" . $err1;
} else {
    // Verifica se a resposta da primeira API é um JSON válido
    $decodedResponse1 = json_decode($response1, true);
    if ($decodedResponse1 === null) {
        echo "Error decoding JSON response from first API.";
    } else {
       // echo "Response from first API: " . $decodedResponse1['text'] . "<br>";

        // Inicializa CURL para a segunda API
        $curl2 = curl_init();
        
        // Configurações do CURL para a segunda API
        curl_setopt_array($curl2, [
            CURLOPT_URL => "https://chatgpt-42.p.rapidapi.com/gpt4?language=pt-PT",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $decodedResponse1['text'] 
                    ]
                ],
                'web_access' => null
            ]),
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: chatgpt-42.p.rapidapi.com",
                "X-RapidAPI-Key: 2faab0b5cbmsh5bea04cf7aff801p17d954jsnf01dd3820fff",
                "content-type: application/json"
            ],
        ]);

        $response2 = curl_exec($curl2);
        $err2 = curl_error($curl2);
        
        curl_close($curl2);
        
        if ($err2) {
            echo "cURL Error #:" . $err2;
        } else {
            $decodedResponse2 = json_decode($response2, true);
            
            if($decodedResponse2 === null){
                echo "Error decoding JSON response from second API.";
            } else {
                //echo "Decoded response from second API: " . $decodedResponse2['result'];
            }
        }
    }
}
?>
        
        <div class="chat">
    <?php if(isset($decodedResponse1['text'])): ?>
      <div class="message">
        <div class="sender">Utilizador</div>
        <div class="text"><?php echo $decodedResponse1['text']; ?></div>
      </div>
    <?php endif; ?>
    <?php if(isset($decodedResponse2['result'])): ?>
      <div class="message">
        <div class="sender">RaspberryPi</div>
        <div class="text"><?php echo $decodedResponse2['result']; ?></div>
      </div>
    <?php endif; ?>
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
