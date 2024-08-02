<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

echo '<pre>';
print_r($_POST);
print_r($_GET);
print_r($_REQUEST);
echo '</pre>';
//exit;
echo 'noreply01@jeevaysoft <br>';
echo $_REQUEST['security'] . '<br>';
if (!empty($_REQUEST['security']) && $_REQUEST['security'] == 'EAFPcgi57QfhCixj8108rBVAp48YTlId1XREqqfOY') {
    echo 'if 1<br>';
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
        echo 'try 2 <br>';
        // Server settings
        $mail->SMTPDebug = false; //SMTP::DEBUG_SERVER; // for detailed debug output
        $mail->isSMTP();
        $mail->Host = 'smtp.office365.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

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

        // Setting the email content
        $mail->IsHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        // $mail->AltBody = 'Plain text message body for non-HTML email client. Gmail SMTP email body.';

        if ($subject != 'Abnormal Report Alert') {
            $mail->send();
        }

        $message['status'] = true;
        $message['message'] = 'Mail delivered.';

        echo json_encode($message);
    } catch (Exception $e) {
        echo 'catch 3<br>';
        $message['status'] = false;
        $message['message'] = '1001: ' . $mail->ErrorInfo;
        echo json_encode($message);
    }
} else {
    echo 'else 4<br>';
    $message['status'] = false;
    $message['message'] = 'Bad request';
    echo json_encode($message);
}

