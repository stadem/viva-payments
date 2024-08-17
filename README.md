# Viva Payments - Minimal Dependencies

[![Latest Version on Packagist](https://img.shields.io/packagist/v/stadem/viva-payments.svg?style=flat-square)](https://packagist.org/packages/stadem/viva-payments)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/github/actions/workflow/status/stadem/viva-payments/php.yml?branch=master)](https://github.com/stadem/viva-payments/actions)
[![Code Quality](https://scrutinizer-ci.com/g/stadem/viva-payments/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/stadem/viva-payments/?branch=master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/stadem/viva-payments/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)



[![VivaPayments logo](./assets/vw-logo.svg "Viva Wallet logo")](https://www.vivawallet.com/)

This package provides a streamlined interface for the Viva Wallet Payment API, enabling seamless integration with **Smart Checkout**, **Webhooks**, and support for both **API v1** and **API v2** calls.

## Features

- **Smart Checkout Integration**: Easily integrate Viva Wallet's Smart Checkout into your application.
- **Webhooks**: Handle Viva Wallet webhooks with minimal setup.
- **API v1 & v2 Support**: Compatible with both versions of the Viva Wallet API.
- **Lightweight & Minimal Dependencies**: Designed to be easy to install and use without unnecessary bloat.


## Installation

Install the package through Composer.

This package requires PHP 8.2 + and no other dependencies.

```
composer require stadem/viva-payments
```

#### Configuration

Rename `viva-config.php.example` to `viva-config.php` and add your credentials.

Add the following data on your `viva-config.php`.

And for you local environment 
```php
    'vivaDEMO' => [
        'VIVA_URL' => 'https://demo.vivapayments.com',
        'VIVA_ACCOUNT_URL' => 'https://demo-accounts.vivapayments.com',
        'VIVA_API_URL' => 'https://demo-api.vivapayments.com',
        'VIVA_API_KEY' => '',
        'VIVA_MERCHANT_ID' => '',
        'VIVA_ENVIRONMENT' => '',
        'VIVA_SOURCE_CODE' => '',
        'VIVA_CLIENT_ID' => '',
        'VIVA_CLIENT_SECRET' => '',
        'VIVA_SMARTCHECKOUT_COLOR'=>'0d1bbd',
        'VIVA_DEBUG'=>0,
    ],
```

And for you production 
```php
'vivaPROD' => [
    'VIVA_URL' => 'https://www.vivapayments.com',
    'VIVA_ACCOUNT_URL' => 'https://accounts.vivapayments.com',
    'VIVA_API_URL' => 'https://api.vivapayments.com',
    'VIVA_API_KEY' => '',
    'VIVA_MERCHANT_ID' => '',
    'VIVA_ENVIRONMENT' => 'prod',
    'VIVA_SOURCE_CODE' => '',
    'VIVA_CLIENT_ID' => '',
    'VIVA_CLIENT_SECRET' => '',
    'VIVA_DEBUG'=>0,
],
```

The total file config.php
```php
return [
    'curlDebug' => 0,
    'defaultProvider' => 'vivaDEMO',
    'vivaDEMO' => [
        'VIVA_URL' => 'https://demo.vivapayments.com',
        'VIVA_ACCOUNT_URL' => 'https://demo-accounts.vivapayments.com',
        'VIVA_API_URL' => 'https://demo-api.vivapayments.com',
        'VIVA_API_KEY' => 'a4bw%t%^',
        'VIVA_MERCHANT_ID' => '123456',
        'VIVA_ENVIRONMENT' => 'demo',
        'VIVA_SOURCE_CODE' => '2222',
        'VIVA_CLIENT_ID' => '123456.vivapayments.com',
        'VIVA_CLIENT_SECRET' => '123456',
        'VIVA_BANK_TRANSFER_URL_API' => 'https://demo.vivapayments.com/api/wallets/{{platformAccountId}}/commands/banktransfer/{{vendorAccountId}}',
        'VIVA_WALLET_TO_WALLET_URL_API'=>'https://demo.vivapayments.com/api/wallets/{{platformAccountId}}/balancetransfer/{{vendorAccountId}}',
        'VIVA_SMARTCHECKOUT_COLOR'=>'0d1bbd',
        'VIVA_DEBUG'=>0,
    ],

    'vivaPROD' => [
        'VIVA_URL' => 'https://www.vivapayments.com',
        'VIVA_ACCOUNT_URL' => 'https://accounts.vivapayments.com',
        'VIVA_API_URL' => 'https://api.vivapayments.com',
        'VIVA_API_KEY' => '',
        'VIVA_MERCHANT_ID' => '',
        'VIVA_ENVIRONMENT' => 'prod',
        'VIVA_SOURCE_CODE' => '',
        'VIVA_CLIENT_ID' => '',
        'VIVA_CLIENT_SECRET' => '',
        'VIVA_DEBUG'=>0
    ]
];
```

> Read more about API authentication on the Developer Portal: https://developer.vivawallet.com/getting-started/find-your-account-credentials/client-smart-checkout-credentials/


## Usage

### Full example
```php
require_once __DIR__ . '/../vendor/autoload.php';
use Stadem\VivaPayments\Enums;
use Stadem\VivaPayments\Services\AccessToken;
use Stadem\VivaPayments\Request\Customer;
use Stadem\VivaPayments\Request\CreatePaymentOrder;

$requestLang = $_REQUEST['requestLang'] ?? 'Greek';
$accessToken = new AccessToken(environment: 'vivaDEMO');

$customer = new Customer(
    $email = 'test@gmail.com',
    $fullName = 'Customer name',
    $phone = '+306941234567',
    $countryCode = 'GR',
    $requestLang = Enums\RequestLang::fromName($requestLang),
);


$CreatePaymentOrder  = [
    'amount'                => 120, 
    'customerTrns'          => 'Test POST - No End Payment', items/services being purchased.
    'paymentTimeout'        => 1800, 
    'preauth'               => false, 
    'allowRecurring'        => false, 
    'maxInstallments'       => 0, 
    'forceMaxInstallments'  => false, 
    'paymentNotification'   => true, 
    'tipAmount'             => 0, 
    'disableExactAmount'    => false, 
    'disableCash'           => true, 
    'disableWallet'         => false, 
    'cardTokens'            => null, Tokens tutorial.
    'merchantTrns'          => 'This is a short description that helps you uniquely identify the transaction', 
    'tags'                  => ['tag1', 'tag2'] 
];


$paymentMethods = [0, 8, 21, 29, 34, 35];


$paymentMethodFees  =  [
    'paymentMethodId' => '35',
    'fee' => 550
];


try {
    $order = new CreatePaymentOrder($CreatePaymentOrder, $accessToken);
    $order->setCustomer($customer);
    $order->setPaymentMethods($paymentMethods);
    $order->setPaymentMethodsFees($paymentMethodFees);

    $getOrderJson = $order->send();
    echo '<a href="' . $order->redirectUrl(PaymentMethods: Enums\PaymentMethods::fromName('VivaWallet')) . '" target="blank">';
    echo $order->getOrderCode();
    echo '</a>';
} catch (Exception  $e) {
    echo 'An error occured: <b>' . $e->getMessage() . '</b>';
}

```


### Get the Access Token
Here’s a quick example of how to get started:

To interact with the Viva Wallet API, you'll first need to obtain an access token. Here’s a quick example of how to get started:


'vivaPROD' => [
Create a file and add the following code, you can switch from the `vivaDEMO` to `vivaProd` evn.
```php
require_once __DIR__ . '/../vendor/autoload.php';
use Stadem\VivaPayments\Enums;
use Stadem\VivaPayments\Services\AccessToken;
use Stadem\VivaPayments\Request\Customer;
use Stadem\VivaPayments\Request\CreatePaymentOrder;

$accessToken = new AccessToken(); // Set the value on config file -> defaultProvider
or
$accessToken = new AccessToken(environment: 'vivaDEMO'); // By direct set, mostly for testing purposes 
```

Additionaly you can access to token and status code by using

```php
$Token = $accessToken->getAccessToken();
$statusCode = $accessToken->getStatusCode();
dump($Token.'-'.$statusCode);
```

### Create new customer
```php
$customer = new Customer(
    $email = 'test@gmail.com',
    $fullName = 'Customer name',
    $phone = '+306941234567',
    $countryCode = 'GR',
    $requestLang = Enums\RequestLang::fromName('Greek'),
);
```

You can set the `requestLang` with multiple ways by type or value.
For further details refer to `src\VivaPayments\Enums\RequestLang`

```php
 RequestLang::Greek
 RequestLang::from('el-GR') // by value
 RequestLang::fromName('Greek') // by name
```

### Create Payment order

```php   

$CreatePaymentOrder  = [
    'amount'                => 120, 
    'customerTrns'          => 'Test POST - No End Payment',
    'paymentTimeout'        => 1800, 
    'preauth'               => false, 
    'allowRecurring'        => false, 
    'maxInstallments'       => 0, 
    'forceMaxInstallments'  => false, 
    'paymentNotification'   => true, 
    'tipAmount'             => 0, 
    'disableExactAmount'    => false, 
    'disableCash'           => true, 
    'disableWallet'         => false, 
    'cardTokens'            => null, Tokens tutorial.
    'merchantTrns'          => 'This is a short description that helps you uniquely identify the transaction', 
    'tags'                  => ['tag1', 'tag2'] 
];

$order = new CreatePaymentOrder($CreatePaymentOrder, $accessToken);



```


<br /> **amount** \
<i>The amount associated with this payment order *100. Must be a positive, non-zero number</i>
<br /> **customerTrns** \
<i> This optional parameter adds a friendly description to the payment order that you want to display to the </i>customer on the payment form. It should be a short description of the 
<br /> **paymentTimeout** \
<i>By using this parameter, you can define a different life span for the Payment Order in sec</i>
<br /> **preauth** \
<i>This will hold the selected amount as unavailable (without the customer being charged) for a period of time</i>
<br /> **allowRecurring** \
<i>If this parameter is set to true, recurring payments are enabled so that the initial transaction ID can be used </i>for subsequent payments. https://developer.viva.com/tutorials/payments/create-a-recurring-payment/</i>
<br /> **maxInstallments** \
<i>The maximum number of installments that the customer can choose for this transaction</i>
<br /> **forceMaxInstallments** \
<i>If this parameter is set to true, the customer will be forced to pay with installments and with the specific number indicated in maxInstallments parameter</i>
<br /> **paymentNotification** \
<i> If you wish to create a payment order, and then send out an email to the customer to request payment</i>
<br /> **tipAmount** \
<i>The tip value (if Applicable for the customer's purchase) which is already included in the amount of the payment </i>order and marked as tip
<br /> **disableExactAmount** \
<i>If this parameter is set to true, then any amount specified in the payment order is ignored (although still </i>mandatory), and the customer is asked to indicate the amount they will pay
<br /> **disableCash** \ 
<i>If this parameter is set to true, the customer will not have the option to pay in cash at a Viva Spot</i>
<br /> **disableWallet** \
<i>If this parameter is set to true, the customer will not have the option to pay using their Viva personal account </i>(wallet)
<br /> **cardTokens** \
<i>You can provide the card tokens you have saved on your backend for this customer. The card tokens will then be </i>presented to the customer on Smart Checkout to pay with. For details, view our Handle Card 
<br /> **merchantTrns** \
<i>This can be either an ID or a short description that helps you uniquely identify the transaction in the viva </i>banking App
<br /> **tags** \
<i>You can add several tags to a transaction that will help in grouping and filtering in the viva banking App</i>



## Create the payment order

The amount requested in cents is required. All the other parameters are optional. Check out the [request body schema](https://developer.vivawallet.com/apis-for-payments/payment-api/#tag/Payments/paths/~1checkout~1v2~1orders/post).

```php
try {
    $order = new CreatePaymentOrder($CreatePaymentOrder, $accessToken);
    $order->setCustomer($customer);
    $order->setPaymentMethods($paymentMethods);
    $order->setPaymentMethodsFees($paymentMethodFees);
    $order->send();
    $redirectUrl = $order->redirectUrl();
} catch (Exception  $e) {
    echo 'An error occured: <b>' . $e->getMessage() . '</b>';
}
```


## Run tests via PEST
You can run tests via PEST with the following command

```
 ./vendor/bin/pest tests/Payments
```


## Upcoming Features
Marketplace API Support: Future updates will include support for marketplace-related API calls.

## Documentation
For comprehensive documentation, please visit the Viva Wallet Developer Portal.

## Contributing
Contributions are welcome! Please submit a pull request or open an issue to discuss potential changes.

## License
This project is licensed under the MIT License. See the LICENSE file for details.

## Disclaimer
Note: This is an unofficial package, and its usage is at your own discretion.








