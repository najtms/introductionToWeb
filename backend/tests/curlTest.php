<?php

// Your API token (example)
$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjp7ImVtYWlsIjoibXVoYW1hZC5hLi5zc2FhZEBzdHUuaWJ1LmVkdS5iYSIsInJvbGUiOiJVU0VSIn0sImlhdCI6MTc0NjQ1OTgxNCwiZXhwIjoxNzQ2NTQ2MjE0LCJyb2xlIjoiVVNFUiJ9.c3jy-fgOsb9C3rfiA6_bhrxdrKMiMha2MH-OJq4umLs";
// Initialize cURL session
$curl = curl_init();

// Set options
curl_setopt_array($curl, [
    CURLOPT_URL => "http://localhost:8888/MuhamadAssaad/introductionToWeb/backend/user",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Authentication:" . $token,
        "Accept: application/json"       // (Optional) specify you want JSON
    ]
]);

// Execute the request
$response = curl_exec($curl);

// Check for errors
if (curl_errno($curl)) {
    echo 'cURL error: ' . curl_error($curl);
} else {
    echo $response;
}

// Close the session
curl_close($curl);
