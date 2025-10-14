<?php

function shorten($longUrl) {
    $data = [
        "domain" => "clc.is",
        "target_url" => $longUrl,
        // optionally "slug" => "customname",
        // optionally "expired_hours" => 48,
    ];

    $ch = curl_init("https://clc.is/api/links");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    if ($response === false) {
        throw new Exception("Curl error: " . curl_error($ch));
    }
    curl_close($ch);

    $obj = json_decode($response, true);
    var_dump($obj[0]['input']['url']);
    if (isset($obj['input']['url'])) {
        return $obj['input']['url'];  // the shortened URL
    } else {
        throw new Exception("Error shortening URL: " . $obj);
    }
}

// Example:
try {
    $short = shorten("https://www.example.com/some/long/url");
    echo "Short link: $short->input->url\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>