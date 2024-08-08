<?php

require_once __DIR__ . '/../vendor/autoload.php';
use Stadem\VivaPayments\Services\AccessToken;


// echo 'hello from proxy';

try{
    $accessToken = new AccessToken();
    $webHookVerification = $accessToken->getWebhookValidationToken();

    echo json_encode($webHookVerification);
    // dump($Token);




    

} catch (Exception  $e) {
    echo 'An error occured: <b>' . $e->getMessage() . '</b>';
}

