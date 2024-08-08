<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Stadem\VivaPayments\Request\Customer;
use Stadem\VivaPayments\Enums;

$requestLang = $_POST['requestLang'] ?? 'Greek';
$customer = new Customer(
    $email = 'stademgr@gmail.com',
    $fullName = 'Stavros Dem',
    $phone = '+306987654321',
    $countryCode = 'GR',
    $requestLang = Enums\RequestLang::fromName($requestLang),
);

dd($customer);