<?php
$config = require __DIR__ . "/../config/config.php";

function check_captcha($token, $config) {
    $ch = curl_init("https://smartcaptcha.yandexcloud.net/validate");
    $args = [
        "secret" => $config['yandex_captcha_server_key'],
        "token" => $token,
        "ip" => $_SERVER['REMOTE_ADDR']
    ];
    curl_setopt($ch, CURLOPT_TIMEOUT, 1);
    curl_setopt($ch, CURLOPT_POST, true);    
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($args));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch); 
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpcode !== 200) {
        //echo "Allow access due to an error: code=$httpcode; message=$server_output\n";
        return true;
    }
 
    $resp = json_decode($server_output);
    return $resp->status === "ok";
}