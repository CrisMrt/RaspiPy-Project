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
        
        // Verifica se o botão "Dados desde o início" foi clicado
        if(isset($_GET['dados_desde_inicio'])) {
            // Query para obter os dados desde o início
            $sql = "SELECT COUNT(*) AS num_registros FROM InformaçõesRPI";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $num_registros = $row['num_registros'];
            echo "<h2> Total Registos desde o início: " .  $num_registros . "</h2>";
        } 

        // Verifica se a data foi selecionada pelo usuário
        if(isset($_GET['selected_date'])) {
            $selected_date = $_GET['selected_date'];
            // Query para obter os dados da data selecionada
            $sql = "SELECT COUNT(*) AS num_registros FROM InformaçõesRPI WHERE DATE(timestamp) = '$selected_date'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $num_registros = $row['num_registros'];
            echo "<h2> Total Registos para " . $selected_date . ": " .  $num_registros . "</h2>";
        } 
      ?>
      

        <!-- Restante do seu HTML continua aqui -->

        <div class="insights">
    <!-- start seling -->
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
    <!-- end seling -->
    <!-- start expenses -->
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
    <!-- end expenses -->
    <!-- start seling -->
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
    
</div>
</body>
</html>
