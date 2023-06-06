<?php
//echo 'ad'; exit;

require 'php/class.phpmailer.php';
require 'php/class.smtp.php';


$mail = new PHPMailer(true);
try {
    // Server settings
    $mail->SMTPDebug = true; //SMTP::DEBUG_SERVER; // for detailed debug output
    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->Username = 'noreply@jeevaysoft.com'; // SMTP username
    $mail->Password = 'Strong*001'; // SMTP password
    $mail->setFrom('noreply@jeevaysoft.com', 'NoReply Jeevaysoft');
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