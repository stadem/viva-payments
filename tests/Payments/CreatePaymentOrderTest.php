
<?php

use Stadem\VivaPayments\Request\Customer;
use Stadem\VivaPayments\Request\CreatePaymentOrder;
use Stadem\VivaPayments\Enums;
use Stadem\VivaPayments\Services\AccessToken;
use Stadem\VivaPayments\Config\Config;
use Stadem\VivaPayments\Traits\getConfigSettings;

$CreatePaymentOrder  = [];


test('payment Order not to be null', function () {
  global $CreatePaymentOrder;
  $accessToken = 'validAccessToken';
  $config = new Config();
  $order = new CreatePaymentOrder($CreatePaymentOrder, $accessToken, $config);
  expect($order)->not->toBeNull();
});


test('test redirect url Default to be valid ', function () {
  global $CreatePaymentOrder;

  $config = new Config();
  $accessToken = new AccessToken($config);
  $order = new CreatePaymentOrder($CreatePaymentOrder, $accessToken, $config);
  $order->setOrderCode('123');

  $redirectUrl =  $order->redirectUrl();
  $url = $config->getEnvConfig('VIVA_URL');
  $color = $config->getEnvConfig('VIVA_SMARTCHECKOUT_COLOR');

  expect($redirectUrl)->toBe($url . '/web2?ref=123&color=' . $color . '&lang=el-GR');
});


test('test redirect url COLOR must be valid ', function () {
  global $CreatePaymentOrder;

  $config = new Config();
  $accessToken = new AccessToken($config);
  $order = new CreatePaymentOrder($CreatePaymentOrder, $accessToken, $config);
  $order->setOrderCode('123');

  $redirectUrl =  $order->redirectUrl(color: 'red');
  $url = $config->getEnvConfig('VIVA_URL');

  expect($redirectUrl)->toBe($url . '/web2?ref=123&color=red&lang=el-GR');
});


test('test redirect url COLOR deafult must be valid ', function () {
  global $CreatePaymentOrder;

  $config = new Config();
  $accessToken = new AccessToken($config);
  $order = new CreatePaymentOrder($CreatePaymentOrder, $accessToken, $config);
  $order->setOrderCode('123');

  $redirectUrl =  $order->redirectUrl();
  $url = $config->getEnvConfig('VIVA_URL');
  $color = $config->getEnvConfig('VIVA_SMARTCHECKOUT_COLOR');

  expect($redirectUrl)->toBe($url . '/web2?ref=123&color=' . $color . '&lang=el-GR');
});



test('test redirect url LANG must be valid ', function () {
  global $CreatePaymentOrder;

  $config = new Config();
  $accessToken = new AccessToken($config);
  $order = new CreatePaymentOrder($CreatePaymentOrder, $accessToken, $config);
  $order->setOrderCode('123');

  $redirectUrl =  $order->redirectUrl(lang: Enums\RequestLang::from('el-GR'));
  $url = $config->getEnvConfig('VIVA_URL');
  $color = $config->getEnvConfig('VIVA_SMARTCHECKOUT_COLOR');

  expect($redirectUrl)->toBe($url . '/web2?ref=123&color=' . $color . '&lang=el-GR');
});


test('test redirect url LANG from string must be valid ', function () {
  global $CreatePaymentOrder;

  $config = new Config();
  $accessToken = new AccessToken($config);
  $order = new CreatePaymentOrder($CreatePaymentOrder, $accessToken, $config);
  $order->setOrderCode('123');

  $redirectUrl =  $order->redirectUrl(lang: 'el-GR');
  $url = $config->getEnvConfig('VIVA_URL');
  $color = $config->getEnvConfig('VIVA_SMARTCHECKOUT_COLOR');

  expect($redirectUrl)->toBe($url . '/web2?ref=123&color=' . $color . '&lang=el-GR');
});



test('test redirect url LANG from NAME must be valid ', function () {
  global $CreatePaymentOrder;

  $config = new Config();
  $accessToken = new AccessToken($config);
  $order = new CreatePaymentOrder($CreatePaymentOrder, $accessToken, $config);
  $order->setOrderCode('123');

  $redirectUrl =  $order->redirectUrl(lang: Enums\RequestLang::fromName('Greek'));
  $url = $config->getEnvConfig('VIVA_URL');
  $color = $config->getEnvConfig('VIVA_SMARTCHECKOUT_COLOR');

  expect($redirectUrl)->toBe($url . '/web2?ref=123&color=' . $color . '&lang=el-GR');
});



test('test redirect url PaymentMethod from NAME must be valid ', function () {
  global $CreatePaymentOrder;

  $config = new Config();
  $accessToken = new AccessToken($config);
  $order = new CreatePaymentOrder($CreatePaymentOrder, $accessToken, $config);
  $order->setOrderCode('123');

  $redirectUrl =  $order->redirectUrl(PaymentMethods: Enums\PaymentMethods::fromName('VivaWallet'));
  $url = $config->getEnvConfig('VIVA_URL');
  $color = $config->getEnvConfig('VIVA_SMARTCHECKOUT_COLOR');

  expect($redirectUrl)->toBe($url . '/web2?ref=123&color=' . $color . '&lang=el-GR&paymentMethod=8');
});

test('test redirect url PaymentMethod from INT must be valid ', function () {
  global $CreatePaymentOrder;

  $config = new Config();
  $accessToken = new AccessToken($config);
  $order = new CreatePaymentOrder($CreatePaymentOrder, $accessToken, $config);
  $order->setOrderCode('123');

  $redirectUrl =  $order->redirectUrl(PaymentMethods: 8);
  $url = $config->getEnvConfig('VIVA_URL');
  $color = $config->getEnvConfig('VIVA_SMARTCHECKOUT_COLOR');

  expect($redirectUrl)->toBe($url . '/web2?ref=123&color=' . $color . '&lang=el-GR&paymentMethod=8');
});



test('test PaymentMethod fromValue must be valid ', function () {

  $value = Enums\PaymentMethods::fromValue(8);

  expect($value)->toBe('VivaWallet');
});



test('Payment Order responce to be equal with', function () {

  $CreatePaymentOrder  = [
    'amount'              => 100,
    'customerTrns'        => 'This is a description displayed to the customer',
    'paymentTimeout'      => 1800,
    'preauth'             => true,
    'allowRecurring'      => true,
    'maxInstallments'     => 0,
    'paymentNotification' => true,
    'tipAmount'           => 1,
    'disableExactAmount'  => true,
    'disableCash'         => false,
    'disableWallet'       => false,
    'sourceCode'          => 'Default',
    'merchantTrns'        => 'This is a short description that helps you uniquely identify the transaction',
    'tags'                => ['tag1', 'tag2']
  ];

  $customer = new Customer(
    $email = 'example@test.com',
    $fullName = 'John Doe',
    $phone = '+306987654321',
    $countryCode = '',
    $requestLang = Enums\RequestLang::from('el-GR'),
  );

  $config = new Config();
  $accessToken = new AccessToken($config);
  $order = new CreatePaymentOrder($CreatePaymentOrder, $accessToken, $config);
  $order->setCustomer($customer);

  // echo $order->toJson();
  // var_dump($someVariable); 
  // expect(true)->toBeTrue();
  expect($order->toJson())->toBe('{"amount":100,"customerTrns":"This is a description displayed to the customer","paymentTimeout":1800,"preauth":true,"allowRecurring":true,"maxInstallments":0,"paymentNotification":true,"tipAmount":1,"disableExactAmount":true,"disableCash":false,"disableWallet":false,"sourceCode":"8541","merchantTrns":"This is a short description that helps you uniquely identify the transaction","tags":["tag1","tag2"],"customer":{"email":"example@test.com","fullName":"John Doe","phone":"+306987654321","countryCode":"","requestLang":"el-GR"},"paymentMethods":null,"paymentMethodFees":[null]}');
  // expect($order->toJson())->toBe('{"amount":100,"customerTrns":"This is a description displayed to the customer","paymentTimeout":1800,"preauth":true,"allowRecurring":true,"maxInstallments":0,"paymentNotification":true,"tipAmount":1,"disableExactAmount":true,"disableCash":false,"disableWallet":false,"sourceCode":"8541","merchantTrns":"This is a short description that helps you uniquely identify the transaction","tags":["tag1","tag2"],"customer":{"email":"example@test.com","fullName":"John Doe","phone":"+306987654321","countryCode":"","requestLang":"el-GR"}}');  
});
