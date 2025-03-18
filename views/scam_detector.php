<?php
require_once "conn.php";
require "vendor/autoload.php";

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}


if (!(isset($_SESSION['auth']) && $_SESSION['auth'] == true && isset($_SESSION['rememberMe']) && $_SESSION['rememberMe'] == true)) {
    if (!isset($_GET['code']) && $_SESSION['auth'] == false) {
        header('Location: /login');
        exit();
    } elseif (isset($_SESSION['auth']) && $_SESSION['auth'] == true) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE uid=:uid");
        $stmt->bindParam("uid", $_SESSION["uid"]);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($result['email_confirmed'] == 0) {
            header('Location: /confirm_email');
            exit();
        }
    }  elseif (isset($_GET['code'])) {
        $client = new Google\Client();
        $client->setClientId("385498786931-fvv9v32cagjb4noshgf7c80n5cb3m5bq.apps.googleusercontent.com");
        $client->setClientSecret("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");
        $client->setRedirectUri("https://daurenkontayev.kz");
    
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    
        $client->setAccessToken($token['access_token']);
        
        $oauth = new Google\Service\Oauth2($client);
    
        $userinfo = $oauth->userinfo->get();
        $email = $userinfo->email;
    
        try {
            $stmt = $conn->prepare('SELECT * FROM users WHERE email=:email AND reg_id=2');
            $stmt->bindParam('email', $email);
            $stmt->execute();
    
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$result) {
                $stmt = $conn->prepare('INSERT INTO users (email, reg_id, email_confirmed) VALUES (:email, 2, 1)');
                $stmt->bindParam('email', $email);
                $stmt->execute();
    
                $stmt = $conn->prepapre('SELECT * FROM users WHERE email=:email AND reg_id=2');
                $stmt->bindParam('email', $email);
                $stmt->execute();
    
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
            }
            $_SESSION['auth'] = true;
            $_SESSION['uid'] = $result['uid'];
            $_SESSION['rememberMe'] = true;
    
        } catch (PDOException $e) {
            echo ''. $e->getMessage() .'';
        }   
    }
}

if ($_SESSION["rememberMe"] == false) {
    $_SESSION["auth"] = false;
}

?>
	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="ToDo App">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<link rel="icon" href="assets/icons/title-icon.ico" type="image/x-icon">
	<link href="https://cdn.lineicons.com/5.0/lineicons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="styles/index.css">
	<title>uSecured: Scam Detector</title>
</head>
<body>
    
    <div class="wrapper">
        <?php include_once 'nav.php' ?>
        
        <div class="main p-3">
            <div class="container">
                in progress
            </div>
        </div>
    </div>

</body>

<script src="../scripts/script.js"></script>
<script src="../scripts/bootstrap.min.js"></script>
<script src="../scripts/main.js"></script>
</html>
