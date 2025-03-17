<?php

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

function getMailer() {
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = "HOST";
    $mail->Port = '465';
    $mail->CharSet = "UTF-8";
    $mail->isHTML();
    $mail->Username = "USERNAME";
    $mail->Password = "PASSWORD";
    $mail->setFrom("NAME", "NAME");

    return $mail;
}

?>