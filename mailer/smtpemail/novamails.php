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
        'noreply001@jeevaysoft.com',  
        'noreply002@jeevaysoft.com',
        'noreply003@jeevaysoft.com',
        'noreply004@jeevaysoft.com',
        'noreply005@jeevaysoft.com',
        'noreply006@jeevaysoft.com',
        'noreply007@jeevaysoft.com',
        'noreply008@jeevaysoft.com',
        'noreply009@jeevaysoft.com',
        'noreply010@jeevaysoft.com'
    );
    
    if(!empty(@$from) && (@$from != 'noreply011@jeevaysoft.com' || @$from != 'noreply013@jeevaysoft.com' || @$from != 'noreply013@jeevaysoft.com' || @$from != 'noreply014@jeevaysoft.com' || @$from != 'noreply015@jeevaysoft.com'  )){
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
            $mail->Username = 'auth@jeevaysoft.com'; // SMTP username
            $mail->setFrom('auth@jeevaysoft.com', 'Jeevay Auth');
        } else if ($_REQUEST['type'] == 'payment') {
            $mail->Username = 'payments@jeevaysoft.com'; // SMTP username
            $mail->setFrom('payments@jeevaysoft.com', 'Jeevay Payments');
        } else if ($_REQUEST['type'] == 'system') {
//            $mail->Username = 'system@jeevaysoft.com'; // SMTP username
//            $mail->setFrom('system@jeevaysoft.com', 'Jeevay System');
            $mail->Username = $randEmail; // SMTP username
            $mail->setFrom($randEmail, 'Jeevay NoReply');
        } else {
            $mail->Username = 'noreply@jeevaysoft.com'; // SMTP username
            $mail->setFrom('noreply@jeevaysoft.com', 'Jeevay NoReply');
        }
        
        $mail->Password = 'Xuh97233!'; // SMTP password

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

