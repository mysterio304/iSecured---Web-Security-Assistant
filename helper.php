<?php

function decodeJwtToken(string $token, string $secretKey, string $algorithm = 'HS256') {
    try {
        return JWT::decodeJwtToken($token, new Key($secretKey, $algorithm));
    } catch (Exception $e) {
        throw new Exception("Invalid or expired token: ".$e->getMessage());
    }
}


function getCurrentTime()
{
    $currentDateTimeObj = new DateTime();
    return $currentDateTimeObj;
}

function validatePassword($password)
{
    $response = ["status" => false, "msg" => ""];
    if (strlen($password) < 8) {
        $response['msg'] = 'Password must contain at least 8 characters';
    } elseif (!preg_match("#[0-9]+#", $password)) {
        $response['msg'] = 'Password must contain at least 1 digit';
    } elseif (!preg_match("#[A-Z]+#", $password)) {
        $response['msg'] = 'Password must contain at least 1 capital letter';
    } elseif (!preg_match("#[a-z]+#", $password)) {
        $response['msg'] = 'Password must contain at least 1 lowercase letter';
    } else {
        $response['status'] = true;
    }

    return $response;
}


function getResponseFromAI($message)
{
    $curl = curl_init();

    $data = [
        'model' => 'gpt-4o',
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
            'Authorization: API-KEY-IS-HERE',
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    $response = json_decode($response, true);

    return $response['choices'][0]['message']['content'];
}


function generateCode() {
    $code = mt_rand(100000, 999999);
    return $code;
}


?>