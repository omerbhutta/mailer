<?php
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://system.jhealth.us/mailer/smtpemail/mailAttachmentTest.php',
//  CURLOPT_URL => 'https://system.azurewebsites.net/mailer/smtpemail/mailAttachmentTest.php',
//  CURLOPT_URL => 'http://novadxmailer.com/smtpemail/mailAttachmentTest.php',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_POSTFIELDS => array(
        'security' => 'EAFPcgi57QfhCixj8108rBVAp48YTlId1XREqqfOY',
        'type' => 'system',
        'subject' => 'Email With Attachment',
        'to' => 'omer@jeevaysoft.com',
        'bcc' => 'iamomerbhutta@gmail.com',
        'from' => 'noreply@jeevaysoft.com',
        'attachmentURL' => 'https://jhealthstorage.file.core.windows.net/dev/jlims_beta/attachments/47/36/Final_Blood_result_report_36_JL060623000036_1686092980175.pdf?sv=2016-05-31&sr=f&se=2050-01-01T08:30:00Z&sp=r&sig=RQUg9dVQ1Sp5NFAI8ZPKfIkRYNfFSwh0549JcPldlMs%3D',
        'attachmentEncoding' => 'base64',
        'attachmentType' => 'application/pdf',
        'body' => 'HelloBody'.time(),
        'security' => 'EAFPcgi57QfhCixj8108rBVAp48YTlId1XREqqfOY'),
    CURLOPT_HTTPHEADER => array(
        'sec-ch-ua: "Google Chrome";v="113", "Chromium";v="113", "Not-A.Brand";v="24"',
        'sec-ch-ua-mobile: ?0',
        'sec-ch-ua-platform: "Windows"',
        'Upgrade-Insecure-Requests: 1',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7'
    ),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response;
//echo '<pre>';
//print_r($response);
//exit;
//print_r("bye");


if (empty($response)) {
    echo 'No response';
} else {
    print_r($response);
}