<?php

//echo 'ad'; exit;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once 'vendor/phpmailer/Exception.php';
require_once 'vendor/phpmailer/PHPMailer.php';
require_once 'vendor/phpmailer/SMTP.php';

$mail = new PHPMailer(true);
try {
    // Server settings
    $mail->SMTPDebug = true; //SMTP::DEBUG_SERVER; // for detailed debug output
    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->Username = 'no-reply@novalabnetics.com'; // SMTP username
    $mail->Password = 'Xuh97233!'; // SMTP password
    $mail->setFrom('no-reply@novalabnetics.com');
    $mail->AddAddress('iamomerbhutta@gmail.com');
    // Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'New Query';
    $mail->Body = 'hello';

    $mail->send();
} catch (Exception $e) {
    echo $errors = "SMTP: Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
echo '<hr>';
?>