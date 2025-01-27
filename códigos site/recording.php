<audio controls><source src='conseguiste.wav' type='audio/wav'> banana </audio>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['startRecording'])) {
  echo "<p>Recording started!</p>";
  $output = shell_exec('/home/pi/Desktop/bash_script.sh');
  echo "<pre><h3>$output</h3></pre>";
  sleep(10);
  header("Location: cenas.php");
  exit;
}
?>