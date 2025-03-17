<?php

$message = 'what is 1+1?';

$curl = curl_init();

$data = [
    'model' => 'gpt-4o-mini',
    'store' => true,
    'messages' => [
        [
            'role' => 'user',
            'content' => $message
        ]
    ]
];
$jsonData = json_encode($data);

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $jsonData,
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: YOUR-API-KEY',
    ),
));

$response = curl_exec($curl);

curl_close($curl);

$response = json_decode($response, true);

echo $response['choices'][0]['message']['content'];

?>