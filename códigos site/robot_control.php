<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['direction'])) {
    $direction = $_POST['direction'];
    $command = escapeshellarg($direction);
    shell_exec("python3 /var/www/html/teste/robot_control.py " . $command);
}
?>
