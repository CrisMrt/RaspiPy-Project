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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    .container {
  display: flex;
}
.chat-container {
  max-width: 600px;
  margin: auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 10px;
  background: #fff;
}

.chat-box {
  height: 400px;
  overflow-y: auto;
  border: 1px solid #ddd;
  padding: 10px;
  border-radius: 10px;
  margin-bottom: 10px;
  background: #f9f9f9;
}

.message {
  margin-bottom: 10px;
  padding: 10px;
  border-radius: 10px;
}

.user-message {
  background: #d1e7dd;
  text-align: right;
}

.bot-message {
  background: #f8d7da;
  text-align: left;
}
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
    </style>
</head>
<body>
   <div class="container">
      <aside>
         <div class="top">
           <div class="logo">
             <h2>R<span class="danger">Mars</span> </h2>
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
          </div>
      </aside>
      
      <main>
        <div class="chat-container">
          <h2>Chat</h2>

          <form method="post" action="">
          </br> 
            <input type="hidden" name="startRecording" value="true">
            <input type="submit" value="Fazer Pergunta" class="button">
            </br>
          </form>
          
          <div class="chat-box" id="chat-box">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
              if (isset($_POST['startRecording'])) {
                $output = shell_exec('/home/pi/Desktop/bash_script.sh');
              }
            }
            ?>

            <?php
            // Caminho do arquivo de áudio
            $audioFilePath = 'conseguiste.wav';

            // Verifica se o arquivo existe
            if (!file_exists($audioFilePath)) {
                echo '<div class="message bot-message">Error: Audio file not found.</div>';
                exit;
            }
            $curl1 = curl_init();

            curl_setopt_array($curl1, [
                CURLOPT_URL => "https://chatgpt-42.p.rapidapi.com/whisperv3", 
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
                    "x-rapidapi-key: 89f028d201msh1b69766d188635dp13e20fjsnaec74d20cbe2"
                ],
            ]);

            $response1 = curl_exec($curl1);
            $err1 = curl_error($curl1);

            curl_close($curl1);

            if ($err1) {
                echo '<div class="message bot-message">cURL Error #:' . $err1 . '</div>';
            } else {
                $decodedResponse1 = json_decode($response1, true);
                if ($decodedResponse1 === null) {
                    echo '<div class="message bot-message">Error decoding JSON response from first API.</div>';
                } else {
                    echo '<div class="message bot-message">Pergunta Feita: ' . $decodedResponse1['text'] . '</div>';

                    $curl2 = curl_init();

                    curl_setopt_array($curl2, [
                        CURLOPT_URL => "https://chatgpt-42.p.rapidapi.com/gpt4",
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
                            'web_access' => false
                        ]),
                        CURLOPT_HTTPHEADER => [
                            "content-type: application/json",
                            "X-RapidAPI-Host: chatgpt-42.p.rapidapi.com",
                            "X-RapidAPI-Key: 89f028d201msh1b69766d188635dp13e20fjsnaec74d20cbe2"
                        ],
                    ]);

                    $response2 = curl_exec($curl2);
                    $err2 = curl_error($curl2);

                    curl_close($curl2);

                    if ($err2) {
                        echo '<div class="message bot-message">cURL Error #:' . $err2 . '</div>';
                    } else {
                        $decodedResponse2 = json_decode($response2, true);

                        if ($decodedResponse2 === null) {
                            echo '<div class="message bot-message">Error decoding JSON response from second API.</div>';
                        } else {
                            echo '<div class="message bot-message">Resposta: ' . $decodedResponse2['result'] . '</div>';
                        }
                    }
                }
            }
            ?>
          </div>
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
