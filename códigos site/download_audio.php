<?php
// Path to the recorded audio file
$audioFilePath = '/home/pi/Desktop/recording.wav';

// Set appropriate headers for audio file download
header('Content-Type: audio/wav');
header('Content-Disposition: attachment; filename="recording.wav"');
header('Content-Length: ' . filesize($audioFilePath));

// Output the audio file
readfile($audioFilePath);
?>
