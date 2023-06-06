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

    $ran = array(
        'noreply@jeevaysoft.com'
    );
    $randEmail = $ran[array_rand($ran, 1)];

    try {
        // Server settings
        $mail->SMTPDebug = false; //SMTP::DEBUG_SERVER; // for detailed debug output
        $mail->isSMTP();
        $mail->Host = 'smtp.office365.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Username = 'noreply@jeevaysoft.com'; // SMTP username
//        $mail->Password = 'MySpMpTLogEmSofJee@4$5#11!'; // SMTP password
        $mail->Password = 'Xuh97233!'; // SMTP password
        $mail->setFrom('noreply@jeevaysoft.com', 'NoReply Jeevaysoft');
//        $mail->setFrom($randEmail, 'NoReply Jeevaysoft');

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

// https://jhealth.jeevaysoft.com/cronJobs/sendPendingPatientEmails
// https://jhealth.jeevaysoft.com/cronJobs/sendPendingOrdersEmails 
