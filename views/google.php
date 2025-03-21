<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);



require "vendor/autoload.php";
$client = new Google\Client();
$client->setClientId("CLIENT-ID");
$client->setClientSecret("CLIENT-SECRET");
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
