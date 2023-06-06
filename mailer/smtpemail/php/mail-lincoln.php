<?php


/**
 * Simple example script using PHPMailer with exceptions enabled
 * @package phpmailer
 * @version $Id$
 */


require_once 'class.phpmailer.php';
require 'class.smtp.php';

try {
//    if (empty($_POST['recaptcha'])) {
//        echo ('Please set recaptcha variable'); exit;
//    }
//    $response = $_POST['recaptcha'];
//    $post = http_build_query(
//        array (
//            'response' => $response,
//            'secret' => '6LeeW64ZAAAAAO3MonFh1KSvGvyPyhz6cy5o-aH8',
//            'remoteip' => $_SERVER['REMOTE_ADDR']
//        )
//    );
//    $opts = array('http' => 
//        array (
//            'method' => 'POST',
//            'header' => 'application/x-www-form-urlencoded',
//            'content' => $post
//        )
//    );
//    $context = stream_context_create($opts);
//    $serverResponse = @file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
//    if (!$serverResponse) {
//        echo ('Failed to validate Recaptcha'); exit;
//    }
//    $result = json_decode($serverResponse);
//    if (!$result->success) {
//        echo ('Invalid Recaptcha'); exit;
//    }
    ///////
    $firstname = isset($_POST['firstname'])? htmlspecialchars($_POST['firstname']) : "";
    $lastname = isset($_POST['lastname'])? htmlspecialchars($_POST['lastname']) : "";
    $email = isset($_POST['email'])? htmlspecialchars($_POST['email']) : "";
    $phone = isset($_POST['phone'])? htmlspecialchars($_POST['phone']) : "";
    $comment = isset($_POST['comment'])? htmlspecialchars($_POST['comment']) : "";
    $radio_select = isset($_POST['radio_select'])? htmlspecialchars($_POST['radio_select']) : "";
    if($radio_select == "lincolnform_radioemail") { $radio_select = "by email"; } elseif($radio_select == "lincolnform_radiophone") { $radio_select = "by phone"; }
	
    $text = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">";
    $text .= "<html><head><title>Email</title><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"><meta name=\"viewport\" content=\"width=device-width\">
<style>
        .footer_col {
            width: 25%;
            padding: 0 32px;
        }
        
        .main_text {
            font-family: 'Cabin', sans-serif;
            font-weight: 700;
            font-size: 24px;
            color: #22539E;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        
        .grey_text {
            font-family: Cabin, sans-serif;
            font-style: normal;
            font-size: 18px;
            line-height: 28px;
            font-weight: 600;
            color: #959595;
        }
        
        .secondary_text {
            width: 375px;
            height: 28px;
            left: 225px;
            top: 201px;
            font-family: Cabin, sans-serif;
            font-style: normal;
            font-weight: 700;
            font-size: 24px;
            line-height: 28px;
            color: #14589C;
        }
		
		td { min-height:52px; vertical-align:top; }
		td span { min-height:26px; display:inline-block; }
        
        @media only screen and (max-width: 1023px) {
            .footer_col {
                width: 50%;
                display: block !important;
                border: none;
                border: none !important;
                padding-right: 20px !important;
                padding-left: 20px !important;
                text-align: center;
                margin: 0 auto;
                box-sizing: border-box;
            }
            .footer_list {
                width: 100%;
                display: block !important;
                text-align: center !important;
            }
            .footer_list span {
                display: none;
            }
        }
        
        @media only screen and (max-width: 600px) {
            .footer_col {
                width: 100%;
            }
        }
    </style>
	</head>";
    $text .= "<body style=\"font-family: 'Open Sans', sans-serif; font-size:18px;font-weight:400;color: #58585B;line-height: 1.4\">";
    $text .= '
    <table width="100%" cellpadding="0" cellspacing="0" border="0" id="header_table">
        <tbody>
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0" border="0" align="center" style="padding: 60px 50px 10px 50px;width: 100%;max-width: 700px;">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="main_text">
                                        Astra-management - New Contact.
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <table width="100%" cellpadding="0" cellspacing="0" border="0" id="content_table">
        <tbody>
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0" border="0" align="center" style="padding: 0px 50px 30px 50px;width: 100%;max-width: 700px;">
                        <tbody>
                            <tr>
                                <td width="50%">
                                    <span class="grey_text">Firstname</span><br>
                                    <span>'.$firstname.'</span>
                                </td>
                                <td>';
								if($lastname != "")
								{
									$text .= '<span class="grey_text">Lastname</span><br>
                                    <span>'.$lastname.'</span>';
								}
								$text .= '
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <table width="100%" cellpadding="0" cellspacing="0" border="0" id="content_table">
        <tbody>
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0" border="0" align="center" style="padding: 0px 50px 30px 50px;width: 100%;max-width: 700px;">
                        <tbody>
                            <tr>
                                <td width="50%">
                                    <span class="grey_text">Phone</span><br>
                                    <span>'.$phone.'</span>
                                </td>
                                <td>
                                    <span class="grey_text">Email</span><br>
                                    <span>'.$email.'</span>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>';
	
	if($radio_select != "") {
	$text .= '	
    <table width="100%" cellpadding="0" cellspacing="0" border="0" id="content_table">
        <tbody>
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0" border="0" align="center" style="padding: 0px 50px 30px 50px;width: 100%;max-width: 700px;">
                        <tbody>
                            <tr>
                                <td>
                                    <span class="grey_text">BEST WAY TO REACH YOU</span><br>
                                    <span>'.$radio_select.'</span>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>';
	}
	
	if($comment != "") {
    $text .= '<hr style="width: 600px; border: 1px solid #DBDCE7;" />
    <table width="100%" cellpadding="0" cellspacing="0" border="0" id="content_table">
        <tbody>
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0" border="0" align="center" style="padding: 10px 50px 60px 50px;width: 100%;max-width: 700px;">
                        <tbody>
                            <tr>
                                <td style="padding-bottom: 30px">
                                    <span class="grey_text">Comment</span><br>
                                    <span>'.$comment.'</span><br>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
	';
	}

    $text .= '
	   <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tbody>
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0" border="0" align="center" style="background: #F2F3F8;padding: 40px 0 15px 0;width: 100%;max-width: 1170px;">
                        <tbody>
                            <tr>
                                <td class="footer_col">
                                    <table width="100%" style="padding: 0 0 20px 0">
                                        <tbody>
                                            <tr>
                                                <td style="text-align:center;">
                                                    <img width="284" style="outline:0px;max-width:100%" src="https://admin.astra-management.ca/src/logo.png">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table width="100%" style="padding: 0 0 20px 20px">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <a href="https://astra-management.ca/certifications" target="_blank"><img width="20" src="https://admin.astra-management.ca/src/certificate-1.png"></a>
                                                </td>
                                                <td>
                                                    <a href="https://astra-management.ca/certifications" target="_blank"><img width="22" src="https://admin.astra-management.ca/src/certificate-2.png"></a>
                                                </td>
                                                <td>
                                                    <a href="https://astra-management.ca/certifications" target="_blank"><img width="22" src="https://admin.astra-management.ca/src/certificate-3.png"></a>
                                                </td>
                                                <td>
                                                    <a href="https://astra-management.ca/certifications" target="_blank"><img width="14" src="https://admin.astra-management.ca/src/certificate-4.png"></a>
                                                </td>
                                                <td>
                                                    <a href="https://astra-management.ca/certifications" target="_blank"><img width="13" src="https://admin.astra-management.ca/src/certificate-5.png"></a>
                                                </td>
                                                <td>
                                                    <a href="https://astra-management.ca/certifications" target="_blank"><img width="22" src="https://admin.astra-management.ca/src/certificate-6.png"></a>
                                                </td>
                                                <td>
                                                    <a href="https://astra-management.ca/certifications" target="_blank"><img width="25" src="https://admin.astra-management.ca/src/certificate-7.png"></a>
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td class="footer_col">
                                    <table width="100%">
                                        <tbody>
                                            <tr>
                                                <td style="border-bottom: 1px solid #6D6D6D; padding: 10px 0;font-size: 18px;font-weight: 700;color: #0D589E;">Calgary Oﬃce
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border-bottom: 1px solid #6D6D6D; padding: 10px 0;font-size: 15px;">
                                                    <img width="24" src="https://admin.astra-management.ca/src/pin.png" style="vertical-align: middle;margin-right: 6px;">
                                                    <a href="https://goo.gl/maps/Nd5R4oHLddMjVaFT9" target="_blank" style="vertical-align: middle; font-size: 15px; color: #58585B; text-decoration: none;">Find
                      Us</a></td>
                                            </tr>
                                            <tr>
                                                <td style="border-bottom: 1px solid #6D6D6D; padding: 10px 0;font-size: 15px;">
                                                    <img width="24" src="https://admin.astra-management.ca/src/phone.png" style="vertical-align: middle;margin-right: 6px;">
                                                    <span style="vertical-align: middle;">(403) 770-6463</span></td>
                                            </tr>
                                            <tr>
                                                <td style="border-bottom: 1px solid #6D6D6D; padding: 10px 0;font-size: 15px;">
                                                    <img width="24" src="https://admin.astra-management.ca/src/email.png" style="vertical-align: middle;margin-right: 6px;">
                                                    <a href="mailto:info@astra-group.ca" style="color: #434243;text-decoration: none;vertical-align: middle;">info@astra-group.ca</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td class="footer_col">
                                    <table width="100%">
                                        <tbody>
                                            <tr>
                                                <td style="border-bottom: 1px solid #6D6D6D; padding: 10px 0;font-size: 18px;font-weight: 700;color: #0D589E;">Edmonton Oﬃce
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border-bottom: 1px solid #6D6D6D; padding: 10px 0;font-size: 15px;">
                                                    <img width="24" src="https://admin.astra-management.ca/src/pin.png" style="vertical-align: middle;margin-right: 6px;">
                                                    <a href="https://goo.gl/maps/fUPiWzoqkEoPfi6y8" target="_blank" style="vertical-align: middle; font-size: 15px; color: #58585B; text-decoration: none;">Find
                      Us</a></td>
                                            </tr>
                                            <tr>
                                                <td style="border-bottom: 1px solid #6D6D6D; padding: 10px 0;font-size: 15px;">
                                                    <img width="24" src="https://admin.astra-management.ca/src/phone.png" style="vertical-align: middle;margin-right: 6px;">
                                                    <span style="vertical-align: middle;">(780) 643-6919</span></td>
                                            </tr>
                                            <tr>
                                                <td style="border-bottom: 1px solid #6D6D6D; padding: 10px 0;font-size: 15px;">
                                                    <img width="24" src="https://admin.astra-management.ca/src/email.png" style="vertical-align: middle;margin-right: 6px;">
                                                    <a href="mailto:info@astra-group.ca" style="color: #434243;text-decoration: none;vertical-align: middle;">info@astra-group.ca</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td style="padding-left:30px" class="footer_col">
                                    <table width="100%">
                                        <tbody>
                                            <tr>
                                                <td style="padding-bottom: 20px;">
                                                    <div style="font-weight: 700;font-size: 17px;color: #EB2227;padding-bottom: 4px;text-align: center;">24/7 EMERGENCY
                                                    </div>
                                                    <div style="font-weight: 700;font-size: 20px;color: #0D589E;text-align: center;">1-833-MY-ASTRA</div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="padding-bottom: 20px;text-align: center;">
                                                    <a href="https://astra-group.ca/" target="_blank" style="color: #14589C;font-size:17px;text-decoration: none;">www.astra-group.ca</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table width="100%" style="text-align: center;">
                                                        <tbody>
                                                            <tr>
                                                                <td width="25">
                                                                    <a href="https://www.facebook.com/astramanagement" target="_blank"><img width="25" src="https://admin.astra-management.ca/src/fb_grey.png"></a>
                                                                </td>
                                                                <td width="25">
                                                                    <a href="https://twitter.com/astramgmt" target="_blank"><img width="25" src="https://admin.astra-management.ca/src/tw_grey.png"></a>
                                                                </td>
                                                                <td width="25">
                                                                    <a href="https://www.linkedin.com/company/astragroupcorp./" target="_blank"><img width="25" src="https://admin.astra-management.ca/src/in_grey.png"></a>
                                                                </td>
                                                                <td width="30">
                                                                    <a href="https://www.youtube.com/channel/UCjd9NvPBiiFXBL0D1mebkwQ" target="_blank"><img width="30" src="https://admin.astra-management.ca/src/youtube_grey.png"></a>
                                                                </td>
                                                                <td width="30">
                                                                    <a href="https://plus.google.com/115546200231998055442" target="_blank"><img width="30" src="https://admin.astra-management.ca/src/gplus_grey.png"></a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:32px 40px 0 40px;" colspan="4">
                                    <div style="font-size: 9px;text-align: center;color: #989898;line-height: 1.4;">This email and any files transmitted with it are confidential and intended solely for the use of the individual or entity to whom they are addressed. If you have received this email in error please notify the system
                                        manager. This message contains confidential information and is intended only for the individual named. If you are not the named addressee you should not disseminate, distribute or copy this e-mail. Please notify
                                        the sender immediately by e-mail if you have received this e-mail by mistake and delete this e-mail from your system. If you are not the intended recipient you are noticed that disclosing, copying, distributing
                                        or taking any action in reliance on the contents of this information is strictly prohibited.
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

        </tbody>
    </table>';
    $text .= "</body>";
    $text .= "</html>";


    $mail = new PHPMailer(true); //New instance, with exceptions enabled
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';

    $body             = $text;
    $body             = preg_replace('/\\\\/','', $body); //Strip backslashes

    /*
	$mail->IsSMTP();                           // tell the class to use SMTP
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    //$mail->Port       = 465;                    // set the SMTP server port
    $mail->Port       = 587;                    // set the SMTP server port
    //$mail->Host       = "smtp.rambler.ru"; // SMTP server
    $mail->Host       = "smtp.gmail.com"; // SMTP server
    // $mail->Username   = "astra-management@rambler.ru";     // SMTP server username
    $mail->Username   = "scheduler@astra-group.ca";     // SMTP server username
    // $mail->Password   = "Astra123";            // SMTP server password
    $mail->Password   = "astra12345";            // SMTP server password

    $mail->IsSendmail();  // tell the class to use Sendmail

    $mail->AddReplyTo("page.aleks@gmail.com","Astra-management");
	
	//$mail->From       = "admin@astra-group.ca";
	//$mail->From       = "scheduler@astra-group.ca";
    $mail->FromName   = "Astra-management";
	*/
	
	//Server settings
        $mail->SMTPDebug = false;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   // Enable SMTP authentication
        $mail->Username = 'scheduler@astra-group.ca';                     // SMTP username
        $mail->Password = 'astra12345';                               // SMTP password
        $mail->SMTPSecure = 'ssl';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
	$mail->setFrom('are@astra-group.ca', 'Astra Group Corp.');

    //$to = "smartnonstop@gmail.com";

    $to = "admin@astra-group.ca";
    // $to = "olehrusin@gmail.com";

    $mail->AddAddress($to);

//    $mail->AddAddress("page.aleks@gmail.com");
    //$mail->AddAddress("peluhnya@gmail.com");
    //$mail->AddAddress("olehrusin@gmail.com");
//    $mail->AddAddress("smartdogzp@gmail.com");
//    $mail->AddAddress("umar.faiz.nvt@gmail.com");
//    $mail->AddAddress("smartnonstop@gmail.com");
    $mail->AddBCC("moazzum@gmail.com"); 

    $mail->Subject  = "Astra-management - New Contact Form";

    $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
    $mail->WordWrap   = 80; // set word wrap

    $mail->MsgHTML($body);

    $mail->IsHTML(true); // send as HTML

    $mail->Send();
    echo 'Message has been sent';

}catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}








/*

$firstname = isset($_POST['firstname'])? htmlspecialchars($_POST['firstname']) : "";
    $lastname = isset($_POST['lastname'])? htmlspecialchars($_POST['lastname']) : "";
    $email = isset($_POST['email'])? htmlspecialchars($_POST['email']) : "";
    $phone = isset($_POST['phone'])? htmlspecialchars($_POST['phone']) : "";
    $comment = isset($_POST['comment'])? htmlspecialchars($_POST['comment']) : "";
    $radio_select = isset($_POST['radio_select'])? htmlspecialchars($_POST['radio_select']) : "";


mail("admin@astra-group.ca", 'Astra-management - New Contact Form',
    "Astra-management - New Contact. Firstname - $firstname, Lastname - $lastname, Email - $email, Phone - $phone, Comment - $comment,
    BEST WAY TO REACH YOU - $radio_select");

*/
//info@astra-group.ca