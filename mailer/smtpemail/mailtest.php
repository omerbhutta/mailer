<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (!empty($_REQUEST['security']) && ($_REQUEST['security'] == 'EAFPcgi57QfhCixj8108rBVAp48YTlId1XREqqfOY' || $_REQUEST['security'] == '34fa4f2fdafd1f2fd065379a2b44e1b0ce99164e') && $subject != 'Abnormal Report Alert') {
    $subject = $_REQUEST['subject'];
    $bccr = $_REQUEST['bcc'];
    $to = $_REQUEST['to'];
    $body = $_REQUEST['body'];
    $from = @$_REQUEST['from'];

    $bccarray = explode(',', $bccr);

    require_once 'vendor/phpmailer/Exception.php';
    require_once 'vendor/phpmailer/PHPMailer.php';
    require_once 'vendor/phpmailer/SMTP.php';

    // passing true in constructor enables exceptions in PHPMailer
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
        $mail->Password = 'Xuh97233!'; // SMTP password
        $mail->setFrom('noreply@jeevaysoft.com', 'NoReply Jeevaysoft');
        $mail->AddAddress('iamomerbhutta@gmail.com');
        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'New Query';
        $mail->Body = 'hello';

        $mail->send();

        $message['status'] = true;
        $message['message'] = 'Mail delivered.';

        echo json_encode($message);
    } catch (Exception $e) {
        echo $errors = "SMTP: Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    $message['status'] = false;
    $message['message'] = 'Bad request';
    echo json_encode($message);
}
?>