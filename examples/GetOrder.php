<?php

require_once __DIR__ . '/../vendor/autoload.php';
use Stadem\VivaPayments\Services\AccessToken;
use Stadem\VivaPayments\Request\Transaction;
use Stadem\VivaPayments\Config\Config;



$vivaTransaction = $_GET['t'] ?? null;
$vivaOrdercode = $_GET['s'] ?? null;


// dd($vivaTransaction.$vivaOrdercode.$vivaTest);
try{
    $config = new Config();
    $accessToken = new AccessToken($config);	
    // $Token = $accessToken->getAccessToken();
    //dump($Token);
    $transaction = new Transaction($accessToken, $config);
    // dump($transaction->getnById($vivaOrdercode));
    // dump($transaction->getByTransaction($vivaTransaction));
    // dump($transaction->getByTransactionV2($vivaTransaction));

    dump($transaction->getByOrderCode($vivaOrdercode));
    

} catch (Exception  $e) {
    echo 'An error occured: <b>' . $e->getMessage() . '</b>';
}

dd($transaction);

