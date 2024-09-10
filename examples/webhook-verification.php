<?php

require_once __DIR__ . '/../vendor/autoload.php';
use Stadem\VivaPayments\Services\AccessToken;
use Stadem\VivaPayments\Config\Config;

// echo 'hello from proxy';

try{
    $config = new Config();
    $accessToken = new AccessToken($config);   
    $webHookVerification = $accessToken->getWebhookValidationToken();

    echo json_encode($webHookVerification);
    // dump($Token);




    

} catch (Exception  $e) {
    echo 'An error occured: <b>' . $e->getMessage() . '</b>';
}

