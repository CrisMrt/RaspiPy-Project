<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['startRecording'])) {
        // Use escapeshellarg to prevent shell injection
        $command = 'arecord -f S16_LE -c1 -r44100 -D plughw:2,0 -d 10 '. escapeshellarg('/home/pi/Desktop/recording.wav');
        $output = shell_exec($command);

        if ($output) {
            echo "<h3>Recording started...</h3>";
            echo "<pre>$output</pre>";
        } else {
            echo "<h3>Error: Unable to start recording.</h3>";
            error_log("Error: Unable to start recording.", 3, "/var/log/php_errors.log");
        }
    } elseif (isset($_POST['playRecording'])) {
        header("Location: download_audio.php");
        exit();
    }
}
?>

<!-- HTML code -->
<!DOCTYPE html>
<html>
<head>
    <title>Record and Play Audio</title>
</head>
<body>
    <form method="post">
        <button type="submit" name="startRecording">Start Recording</button>
        <button type="submit" name="playRecording">Play Recording</button>
    </form>
</body>
</html>