<?php

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://novadxmailer.com/smtpemail/ms.php',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array(
        'subject' => 'subject-here',
        'bcc' => 'iamomerbhutta@gmail.com,muhammado@novadxlabs.com',
        'to' => 'umarfaiz95@gmail.com',
        'body' => 'hello world.',
        'security' => 'EAFPcgi57QfhCixj8108rBVAp48YTlId1XREqqfOY',
    ),
));

$response = curl_exec($curl);

curl_close($curl);

//$data = json_decode($response);

//echo '<pre>';
//print_r($response);
//echo '</pre>';
