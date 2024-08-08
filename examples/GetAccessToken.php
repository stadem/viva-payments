<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Stadem\VivaPayments\Enums;
use Stadem\VivaPayments\Services\AccessToken;
use Stadem\VivaPayments\Request\Customer;
use Stadem\VivaPayments\Request\CreatePaymentOrder;


$accessToken = new AccessToken();
$Token = $accessToken->getAccessToken();
$statusCode = $accessToken->getStatusCode();
dd($Token);