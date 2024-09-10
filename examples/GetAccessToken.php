<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Stadem\VivaPayments\Enums;
use Stadem\VivaPayments\Services\AccessToken;
use Stadem\VivaPayments\Request\Customer;
use Stadem\VivaPayments\Request\CreatePaymentOrder;
use Stadem\VivaPayments\Config\Config;

$config = new Config();
$accessToken = new AccessToken($config);	
$Token = $accessToken->getAccessToken();
$statusCode = $accessToken->getStatusCode();
dd($Token);