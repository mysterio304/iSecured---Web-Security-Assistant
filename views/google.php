<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);



require "vendor/autoload.php";
$client = new Google\Client();
$client->setClientId("385498786931-fvv9v32cagjb4noshgf7c80n5cb3m5bq.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("https://daurenkontayev.kz");

$client->addScope("email");
$client->addScope("profile");

$url = $client->createAuthUrl();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Login</title>
</head>
<body>
    <a href="<?=$url?>">Sign in with Google</a>
</body>
</html>