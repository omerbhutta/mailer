<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once 'vendor/phpmailer/Exception.php';
require_once 'vendor/phpmailer/PHPMailer.php';
require_once 'vendor/phpmailer/SMTP.php';

$mail = new PHPMailer(true);

if (!empty(@$_REQUEST['security']) && @$_REQUEST['security'] == 'EAFPcgi57QfhCixj8108rBVAp48YTlId1XREqqfOY') {
    $subject = @$_REQUEST['subject'];
    $bccr = @$_REQUEST['bcc'];
    $to = @$_REQUEST['to'];
    $body = @$_REQUEST['body'];
    $from = @$_REQUEST['from'];
    $attachmentURL = @$_REQUEST['attachmentURL'];
    $attachmentEncoding = @$_REQUEST['attachmentEncoding'];
    $attachmentType = @$_REQUEST['attachmentType'];
    $bccarray = explode(',', $bccr);
    $localPath = '';

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
        if (!empty($from)) {
            $mail->Username = $from; // SMTP username
            $mail->setFrom($from, 'NoReply');
        } else {
            $mail->Username = 'noreply@jeevaysoft.com'; // SMTP username
            $mail->setFrom('noreply@jeevaysoft.com', 'NoReply Jeevaysoft');
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
        $mail->AddBCC('support@jeevaysoft.com');
        // Setting the email content
        $mail->IsHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        if (!empty(@$_REQUEST['attachmentURL'])) {
            $attachmentURL = @$_REQUEST['attachmentURL'];
            $url = $attachmentURL;
            $file_name = parse_url($url, PHP_URL_PATH);
            $file_name = explode('/', parse_url($file_name, PHP_URL_PATH));
            $file_name = end($file_name);
            if (file_put_contents(__DIR__ . "/attachments/" . $file_name, file_get_contents($url))) {
                $localPath = __DIR__ . "/attachments/" . $file_name;
                $mail->addAttachment($localPath, $file_name);
            }
        }
        $mail->send();
        unlink($localPath);
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