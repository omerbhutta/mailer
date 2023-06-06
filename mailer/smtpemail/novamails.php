<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (!empty($_REQUEST['security']) && $_REQUEST['security'] == 'EAFPcgi57QfhCixj8108rBVAp48YTlId1XREqqfOY') {
    $subject = $_REQUEST['subject'];
    $bccr = $_REQUEST['bcc'];
    $to = $_REQUEST['to'];
    $fromPayloadEmail = @$_REQUEST['from'];
    $body = $_REQUEST['body'];

    $bccarray = explode(',', $bccr);

    require_once 'vendor/phpmailer/Exception.php';
    require_once 'vendor/phpmailer/PHPMailer.php';
    require_once 'vendor/phpmailer/SMTP.php';

    // passing true in constructor enables exceptions in PHPMailer
    $mail = new PHPMailer(true);
    
    $ran = array(
        'noreply001@novadxlabs.com',  
        'noreply002@novadxlabs.com',
        'noreply003@novadxlabs.com',
        'noreply004@novadxlabs.com',
        'noreply005@novadxlabs.com',
        'noreply006@novadxlabs.com',
        'noreply007@novadxlabs.com',
        'noreply008@novadxlabs.com',
        'noreply009@novadxlabs.com',
        'noreply010@novadxlabs.com'
    );
    
    if(!empty(@$from) && (@$from != 'noreply011@novadxlabs.com' || @$from != 'noreply013@novadxlabs.com' || @$from != 'noreply013@novadxlabs.com' || @$from != 'noreply014@novadxlabs.com' || @$from != 'noreply015@novadxlabs.com'  )){
        $randEmail = $fromPayloadEmail;
    }else{
        $randEmail = $ran[array_rand($ran, 1)];
    }
    
    
    
    try {
        // Server settings
        $mail->SMTPDebug = false; //SMTP::DEBUG_SERVER; // for detailed debug output
        $mail->isSMTP();
        $mail->Host = 'smtp.office365.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        if ($_REQUEST['type'] == 'auth') {
            $mail->Username = 'auth@novadxlabs.com'; // SMTP username
            $mail->Password = 'N0v@uth123!'; // SMTP password
            $mail->setFrom('auth@novadxlabs.com', 'NovaDx Auth');
        } else if ($_REQUEST['type'] == 'payment') {
            $mail->Username = 'payments@novadxlabs.com'; // SMTP username
//            $mail->Password = 'N0va7861Pay!'; // SMTP password
            $mail->Password = 'N0v@uth123!'; // SMTP password
            $mail->setFrom('payments@novadxlabs.com', 'NovaDx Payments');
        } else if ($_REQUEST['type'] == 'system') {
//            $mail->Username = 'system@novadxlabs.com'; // SMTP username
//            $mail->Password = 'N0va$ys321!'; // SMTP password
//            $mail->setFrom('system@novadxlabs.com', 'NovaDx System');
            $mail->Username = $randEmail; // SMTP username
            $mail->Password = 'N0v@Labs1234!'; // SMTP password
            $mail->setFrom($randEmail, 'NovaDx NoReply');
        } else {
            $mail->Username = 'noreply@novadxlabs.com'; // SMTP username
            $mail->Password = 'N0v@Labs1234!'; // SMTP password
            $mail->setFrom('noreply@novadxlabs.com', 'NovaDx NoReply');
        }

        $mail->AddAddress($to);

        if (!empty($bccarray)) {
            foreach ($bccarray as $bcc) {
                if (!empty($bcc)) {
                    $mail->AddBCC($bcc);
                }
            }
        }

        // Setting the email content
        $mail->IsHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        // $mail->AltBody = 'Plain text message body for non-HTML email client. Gmail SMTP email body.';

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

