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
            $mail->Username = 'system@novadxlabs.com'; // SMTP username
            $mail->Password = 'N0va$ys321!'; // SMTP password
            $mail->setFrom('system@novadxlabs.com', 'NovaDx System');
            pffmail();
        } else {
            $mail->Username = 'noreply@novadxlabs.com'; // SMTP username
            $mail->Password = 'N0v@Labs1234!'; // SMTP password
            $mail->setFrom('noreply@novadxlabs.com', 'NovaDx NoReply');
        }

        $mail->AddAddress($to);
        if (!empty($bccarray)) {
            foreach ($bccarray as $bcc) {
                $mail->AddBCC($bcc);
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
exit;
function pffmail() {

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
        
        //Decoding Attachments 
        $attachments = json_decode($_REQUEST['attachments'],true);

        // Server settings
        $mail->SMTPDebug = false; //SMTP::DEBUG_SERVER; // for detailed debug output
        $mail->isSMTP();
        $mail->Host = 'smtp.office365.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->Username = 'system@novadxlabs.com'; // SMTP username
        $mail->Password = 'N0va$ys321!'; // SMTP password
        $mail->setFrom('system@novadxlabs.com', 'NovaDx System');
        $mail->AddAddress('alirazasoft@gmail.com');
        $mail->AddBCC('iamomerbhutta@gmail.com');
        $mail->AddBCC('araza5@outlook.com');
        
        
        //Attachments

        
         //Add attachments
        if(count($attachments)>0){

           foreach ($attachments as $key => $value)
            {
                file_put_contents(__DIR__ ."/attachments/".$key, fopen($value, 'r'));

                $mail->addAttachment(__DIR__ ."/attachments/".$key, $key);    //Optional name
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

        register_shutdown_function('shutdown');

        echo json_encode($message);

      
     function shutdown()
    {
        global $attachments;

    if(count($attachments)>0){

        foreach ($attachments as $key => $value)
         {
             unlink(__DIR__ ."/attachments/".$key);
         }
     }
  }


        //sleep(30);


    } catch (Exception $e) {
        $message['status'] = false;
        $message['message'] = $mail->ErrorInfo;
        echo json_encode($message);
    }
}
