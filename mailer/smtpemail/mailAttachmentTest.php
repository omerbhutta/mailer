<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (!empty($_REQUEST['security']) && ($_REQUEST['security'] == 'EAFPcgi57QfhCixj8108rBVAp48YTlId1XREqqfOY' || $_REQUEST['security'] == '34fa4f2fdafd1f2fd065379a2b44e1b0ce99164e')) {
    $subject = $_REQUEST['subject'];
    $bccr = @$_REQUEST['bcc'];
    $to = $_REQUEST['to'];
    $body = $_REQUEST['body'];
    $from = $_REQUEST['from'];
    $attachmentURL = $_REQUEST['attachmentURL'];
    $attachmentEncoding = $_REQUEST['attachmentEncoding'];
    $attachmentType = $_REQUEST['attachmentType'];

    // Function to check if an email contains any forbidden words
    function containsForbiddenWord($email, $forbiddenWords) {
        foreach ($forbiddenWords as $word) {
            if (strpos($email, $word) !== false) {
                return true; // Return true if the email contains any forbidden word
            }
        }
        return false; // Return false if no forbidden word is found in the email
    }

    // Define the list of forbidden email addresses
    $forbiddenEmails = array(
        'noreply@jeevaysoft.com',
        'noreply@txdxlabs.com',
        'noemail@jeevaysoft.com'
    );

    // Define the list of forbidden words
    $forbiddenWords = array(
        'noreply',
        'test',
        'testing',
        'test.com'
    );

    // Check if the provided email matches any of the forbidden email addresses or contains any forbidden words
    if (in_array($to, $forbiddenEmails) || containsForbiddenWord($to, $forbiddenWords)) {
        // Set $to to false if it matches any of the forbidden criteria
        $message['status'] = false;
        $message['message'] = $to . ' is a Test/Wrong/Invalid Email Address';
        echo json_encode($message);
        exit;
    }




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
        if (!empty($from)) {
            $mail->Username = $from; // SMTP username
            $mail->setFrom($from, 'NoReply');
        } else {
            $mail->Username = 'noreply@jeevaysoft.com'; // SMTP username
            $mail->setFrom('noreply@jeevaysoft.com', 'NoReply Jeevaysoft');
        }

//        $mail->Username = 'noreply01@jeevaysoft.com'; // SMTP username
//            $mail->setFrom('noreply01@jeevaysoft.com', 'NoReply Jeevaysoft');

        $mail->Password = 'Xuh97233!'; // SMTP password
        $mail->AddAddress($to);

        if (!empty($bccarray)) {
            foreach ($bccarray as $bcc) {
                if (!empty($bcc)) {
                    $mail->AddBCC($bcc);
                }
            }
        }
//        $mail->AddBCC('support@jeevaysoft.com');
        // Setting the email content
        $mail->IsHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        // $mail->AltBody = 'Plain text message body for non-HTML email client. Gmail SMTP email body.';

        if (!empty($attachmentURL)) {

            // Initialize a file URL to the variable
            $url = $attachmentURL;

            // Use basename() function to return the base name of file
            $file_name = basename($url);

            // Use file_get_contents() function to get the file
            // from url and use file_put_contents() function to
            // save the file by using base name
            if (file_put_contents(__DIR__ . "/attachments/" . $file_name . ".pdf", file_get_contents($url))) {
                $mail->addAttachment(__DIR__ . "/attachments/" . $file_name . ".pdf", $file_name . '.pdf', $attachmentEncoding, $attachmentType);    //Optional name 
            }
        }
        if ($subject != 'Abnormal Report Alert') {
            $mail->send();
        }


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
