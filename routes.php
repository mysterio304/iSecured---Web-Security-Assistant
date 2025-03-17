<?php

require_once __DIR__ . '/router.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

get('/', 'views/index.php');
get('/login', 'views/login.php');
get('/register', 'views/register.php');
get('/forgot_password', 'views/forgot_password.php');
get('/reset_password', 'views/reset_password.php');
get('/confirm_email', 'views/confirm_email.php');
get('/password_generator', 'views/password_generator.php');
get('/phishing_email_detector', 'views/phishing_email_detector.php');
get('/scam_detector', 'views/scam_detector.php');
get('/about', 'views/about.php');

// TESTING
get('/gpt', 'views/gpt.php');
get('/google', 'views/google.php');


get('/info', function () {
    $ip = "";
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    $referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'Direct Access';
    $userAgent = $_SERVER['HTTP_USER_AGENT'];

    $msg = ["ip" => $ip, 'referrer' => $referrer, "user-agent" => $userAgent];
    echo json_encode($msg);
});


post('/registerUser', function () {
    header('Content-Type: application/json; charset=utf-8');
    require_once 'conn.php';

    $msg = ["status" => false, "msg" => ""];

    if (!empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['confirm_password'])) {
        $password = htmlspecialchars($_POST["password"]);
        $email = htmlspecialchars($_POST["email"]);
        $confirm_password = htmlspecialchars($_POST["confirm_password"]);

        $stmt = $conn->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $msg["msg"] = "This email is already registered";
        } else if (trim($password) == trim($confirm_password)) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $token = bin2hex(random_bytes(16));
            $token_hash = hash("sha256", $token);

            $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $password_hash);

            if ($stmt->execute()) {
                $msg["status"] = true;
                $msg["msg"] = 'Registered successfully';
                $stmt = $conn->prepare("SELECT * FROM users WHERE email=:email");
                $stmt->bindParam("email", $email);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                $_SESSION["auth"] = true;
                $_SESSION["uid"] = $result["uid"];
                $_SESSION["rememberMe"] = true;
            } else {
                $msg["msg"] = "Something went wrong";
            }
        } else {
            $msg["msg"] = "The passwords do not match";
        }
    } else {
        $msg["msg"] = "Some arguments are missing";
    }

    echo json_encode($msg);
});


post('/loginUser', function () {
    header('Content-Type: application/json; charset=utf-8');
    require_once 'conn.php';
    require 'vendor/autoload.php';

    $msg = ["status" => false, "msg" => ""];

    if (isset($_SESSION['auth']) && $_SESSION['auth'] == true) {
        $msg['status'] = true;
        $msg['msg'] = "You are logged in";
        echo json_encode($msg);
        return;
    }

    if (!empty($_POST['password']) && !empty($_POST['email'])) {
        $password = htmlspecialchars($_POST['password']);
        $email = htmlspecialchars($_POST['email']);
        $rememberMe = htmlspecialchars($_POST['rememberMe']);

        $stmt = $conn->prepare('SELECT * FROM users WHERE email=:email');
        $stmt->bindParam("email", $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            if (password_verify($password, $result["password"])) {
                if ($rememberMe == "true") {
                    $rememberMe = true;
                } elseif ($rememberMe == "false") {
                    $rememberMe = false;
                }
                
                $_SESSION['rememberMe'] = $rememberMe;
                $_SESSION['auth'] = true;
                $_SESSION['uid'] = $result['uid'];

                $msg['status'] = true;
                $msg['msg'] = 'Logged in successfully';
            } else {
                $_SESSION['auth'] = false;
                $msg['msg'] = "The password is wrong";
            }
        } else {
            $msg['msg'] = "No account found with the provided email";
        }
    } else {
        $msg['msg'] = "Something went wrong";
    }

    echo json_encode($msg);
});


post("/loginGoogleUser", function () {
    header("Content-Type: application/json; charset=utf-8");
    require 'vendor/autoload.php';

    $msg = ['status' => false, 'msg' => ''];

    try {
        $client = new Google\Client();
        $client->setClientId("CLIENT-ID");
        $client->setClientSecret("CLIENT-SECRET");
        $client->setRedirectUri("https://daurenkontayev.kz");
        $client->addScope("email");
        $client->addScope("profile");
    
        $url = $client->createAuthUrl();
        $msg['msg'] = $url;
        $msg['status'] = true;
    } catch (Exception $e) {
        $msg['msg'] = $e->getMessage();
    }

    echo json_encode($msg);
    
});


post("/sendPasswordReset", function () {
    header('Content-Type: application/json; charset=utf-8');
    require_once 'conn.php';
    require 'mailer.php';

    $msg = ['status' => false, 'msg' => ''];

    if (!empty($_POST['email'])) {
        $email = htmlspecialchars($_POST['email']);

        $token = bin2hex(random_bytes(16));
        $token_hash = hash("sha256", $token);
        $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

        $stmt = $conn->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->bindParam("email", $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $stmt = $conn->prepare("UPDATE users SET reset_token_hash=:reset_token_hash, reset_token_expires_at=:reset_token_expires_at WHERE email=:email");
            $stmt->bindParam("reset_token_hash", $token_hash);
            $stmt->bindParam("reset_token_expires_at", $expiry);
            $stmt->bindParam("email", $email);
            if ($stmt->execute()) {
                $mail = getMailer();
                $mail->addAddress($email);

                $mail->Subject = 'Password Reset';
                $mail->Body = <<<END
              
              <h1>Click <a href="http://daurenkontayev.kz/reset_password?token=$token">here</a> to reset your password.</h1>
  
              END;
                try {
                    $mail->send();
                    $msg["status"] = true;
                    $msg["msg"] = "Email has been sent";
                } catch (Exception $e) {
                    echo "Message could be sent. Mailer error: {$mail->ErrorInfo}";
                    $msg["msg"] = $mail->ErrorInfo;
                    $msg["status"] = false;
                }

            }
        } else {
            $msg["msg"] = "No account found with the provided email";
        }
    } else {
        $msg["msg"] = "Something went wrong";
    }

    echo json_encode($msg);
});


post("/updatePassword", function () {
    header('Content-Type: application/json; charset=utf-8');
    require_once 'conn.php';
    require 'helper.php';

    $msg = ['status' => false, 'msg' => ''];

    if (!empty($_POST['password']) && !empty($_POST['confirm_password']) && !empty($_POST['token'])) {
        $password = htmlspecialchars($_POST['password']);
        $confirmPassword = htmlspecialchars($_POST['confirm_password']);
        $token = $_POST['token'];
        $token_hash = hash("sha256", $token);

        $stmt = $conn->prepare("SELECT * FROM users WHERE reset_token_hash=:reset_token_hash");
        $stmt->bindParam("reset_token_hash", $token_hash);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $currentDatetime = getCurrentTime();
            $expireDatetime = new DateTime($result['reset_token_expires_at']);

            if ($expireDatetime > $currentDatetime) {
                if (trim($password) == trim($confirmPassword)) {
                    if (!password_verify($password, $result['password'])) {
                        $passwordValidation = validatePassword($password);
                        if ($passwordValidation['status']) {
                            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                            $stmt = $conn->prepare("UPDATE users SET password=:password WHERE reset_token_hash=:reset_token_hash");
                            $stmt->bindParam('password', $passwordHash);
                            $stmt->bindParam('reset_token_hash', $token_hash);
                            if ($stmt->execute()) {
                                $msg['status'] = true;
                                $msg['msg'] = 'Password has been updated';

                                $stmt = $conn->prepare("UPDATE users SET reset_token_hash=NULL, reset_token_expires_at=NULL WHERE reset_token_hash=:reset_token_hash");
                                $stmt->bindParam("reset_token_hash", $token_hash);
                                $stmt->execute();
                            }
                        } else {
                            $msg['msg'] = $passwordValidation['msg'];
                        }
                    } else {
                        $msg['msg'] = 'You can not choose the previous password';
                    }
                } else {
                    $msg['msg'] = "Passwords do not match";
                }

            } else {
                $msg['msg'] = 'The link is expired';
            }
        } else {
            $msg['msg'] = 'Incorrect link';
        }
    } else {
        $msg['msg'] = 'Something went wrong';
    }

    echo json_encode($msg);
});


post("/sendConfirmEmail", function () {
    header("Content-Type: application/json; charset=utf-8");
    require_once "conn.php";
    require "helper.php";
    require "mailer.php";

    $msg = ['status' => false, 'msg' => ''];

    if (!empty($_SESSION['uid'])) {
        $uid = htmlspecialchars($_SESSION['uid']);
        $msg['uid'] = $uid;
        $stmt = $conn->prepare('SELECT * FROM users WHERE uid=:uid');
        $stmt->bindParam('uid', $uid);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $email = $result['email'];

        if ($result) {
            $code = generateCode();

            $stmt = $conn->prepare('UPDATE users SET email_confirm_code=:email_confirm_code WHERE uid=:uid');
            $stmt->bindParam('email_confirm_code', $code);
            $stmt->bindParam('uid', $uid);

            if ($stmt->execute()) {
                $mail = getMailer();
                $mail->addAddress($email);
                $mail->Subject = 'Email Confirmation';
                $mail->Body = <<<END

                <h1>Your email confirmation code is: $code</h1>
                
                END;

                try {
                    $mail->send();
                    $msg['status'] = true;
                    $msg['msg'] = 'The code has been sent on your email';
                } catch (Exception $e) {
                    echo "Message could be sent. Mailer error: {$mail->ErrorInfo}";
                    $msg["msg"] = $mail->ErrorInfo;
                    $msg["status"] = false;
                }
            }

            
        } else {
            $msg['msg'] = 'Something went wrong (user not found)';
        }
    } else {
        $msg['msg'] = 'You are not logged in';
    }

    echo json_encode($msg);
});


post("/confirmEmail", function () {
    header("Content-Type: application/json; charset=utf-8");
    require_once 'conn.php';

    $msg = ["status" => false, "msg" => ""];

    if (!empty($_POST['email_confirm_code']) && !empty($_SESSION['uid'])) {
        $emailConfirmCode = htmlspecialchars($_POST['email_confirm_code']);
        $uid = htmlspecialchars($_SESSION['uid']);

        $stmt = $conn->prepare('SELECT * FROM users WHERE uid=:uid');
        $stmt->bindParam('uid', $uid);

        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result['email_confirmed'] == 0) {
                if ($result['email_confirm_code'] == $emailConfirmCode) {
                    $stmt = $conn->prepare('UPDATE users SET email_confirmed=1, email_confirm_code=NULL WHERE uid=:uid');
                    $stmt->bindParam('uid', $uid);
                    if ($stmt->execute()) {
                        $msg['status'] = true;
                        $msg['msg'] = 'Email has been confirmed successfully';
                    } else {
                        $msg['msg'] = 'Something went wrong';
                    }
                } else {
                    $msg['msg'] = 'Wrong confirmation code';
                }
            } else {
                $msg['msg'] = 'Email is already confirmed';
            }
        } else {
            $msg['msg'] = 'Something went wrong (user not found)';
        }
    } else {
        $msg['msg'] = 'Something went wrong';
    }

    echo json_encode($msg);
});


post("/getResponseFromAI", function () {
    header('Content-Type: application/json; charset=utf-8');
    require "helper.php";

    $msg = ['status' => false, 'msg' => ''];

    if (isset($_POST) && !empty($_POST['message'])) {
        $message = htmlspecialchars($_POST['message']);

        try {
            $response = getResponseFromAI($message);

            $msg['msg'] = $response;
            $msg['status'] = true;
        } catch (Exception $e) {
            $msg['msg'] = $e->getMessage();
        }
    } else {
        $msg['msg'] = 'Some argument are missing';
    }

    echo json_encode($msg);
});


get("/logout", function () {
    session_unset();
    session_destroy();
    header("Location: /login");
});


any('/404', 'views/404.php');