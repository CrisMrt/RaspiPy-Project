<?php

// Check if the form is submitted
if (isset($_POST['submit'])) {
    
    // Path to the audio file
    $audioFilePath = 'conseguiste.wav';

    // Check if the file exists
    if (!file_exists($audioFilePath)) {
        echo "Error: Audio file not found.";
        exit;
    }

    // Initialize CURL
    $curl = curl_init();

    // Set CURL options
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://chatgpt-42.p.rapidapi.com/whisperv3",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => file_get_contents($audioFilePath), // Read file contents
        CURLOPT_HTTPHEADER => [
            "Content-Type: audio/wav", // Set appropriate content type for audio file
            "x-rapidapi-host: chatgpt-42.p.rapidapi.com",
            "x-rapidapi-key: 89f028d201msh1b69766d188635dp13e20fjsnaec74d20cbe2"
        ],
    ]);

    // Execute CURL request
    $response = curl_exec($curl);
    $err = curl_error($curl);

    // Close CURL
    curl_close($curl);

    // Check for CURL errors
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response; // Output response from the API
    }
} else {
    echo "Form not submitted."; // If form is not submitted
}
?>
