<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (!empty($_REQUEST['security']) && $_REQUEST['security'] == 'EAFPcgi57QfhCixj8108rBVAp48YTlId1XREqqfOY') {
    $subject = $_REQUEST['subject'];
    $bccr = $_REQUEST['bcc'];
    $to = $_REQUEST['to'];
    $body = $_REQUEST['body'];

    $bccarray = explode(',', $bccr);

    require_once 'vendor/phpmailer/Exception.php';
    require_once 'vendor/phpmailer/PHPMailer.php';
    require_once 'vendor/phpmailer/SMTP.php';

// passing true in constructor enables exceptions in PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = false; //SMTP::DEBUG_SERVER; // for detailed debug output
        $mail->isSMTP();
        $mail->Host = 'smtp.office365.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->Username = 'noreply@novadxlabs.com'; // SMTP username
        $mail->Password = 'N0v@Labs1234!'; // SMTP password
        // Sender and recipient settings
        $mail->setFrom('noreply@novadxlabs.com', 'Muhammad Omer');
        $mail->addAddress($to);
//    $mail->AddBCC("umarfaiz@msn.com");

        foreach ($bccarray as $bcc) {
            $mail->AddBCC($bcc);
        }

//    $mail->addReplyTo('example@gmail.com', 'Sender Name'); // to set the reply to
        // Setting the email content
        $mail->IsHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
//    $mail->AltBody = 'Plain text message body for non-HTML email client. Gmail SMTP email body.';

        $mail->send();

        $message['status'] = true;
        $message['message'] = 'Mail delivered.';

        echo json_encode($message);
    } catch (Exception $e) {
        $message['status'] = false;
        $message['message'] = $mail->ErrorInfo;
        echo json_encode($message);
    }
} else {
    $message['status'] = false;
    $message['message'] = 'Bad request';
    echo json_encode($message);
}

