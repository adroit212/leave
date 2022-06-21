<?php
$url = 'https://smartsmssolutions.com/api/';
$senderid = 'Leave Management System';
$token = '********************************';

function sendsms_post($url, array $params1) {
    $params = http_build_query($params1);
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function validate_sendsms($response) {
    $validate = explode('||', $response);
    if ($validate[0] == '1000') {
        return TRUE;
    } else {
        return FALSE;
    }
}
