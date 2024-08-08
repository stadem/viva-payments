<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Stadem\VivaPayments\Enums;
use Stadem\VivaPayments\Services\AccessToken;
use Stadem\VivaPayments\Request\Customer;
use Stadem\VivaPayments\Request\CreatePaymentOrder;


$accessToken = new AccessToken();
$Token = $accessToken->getAccessToken();
$statusCode = $accessToken->getStatusCode();
// dd($Token);

$requestLang = $_POST['requestLang'] ?? 'Greek';
$customer = new Customer(
    $email = 'stademgr@gmail.com',
    $fullName = 'Stavros Dem',
    $phone = '+306987654321',
    $countryCode = 'GR',
    $requestLang = Enums\RequestLang::fromName($requestLang),
);

// dd($customer);
// print_r($customer->toArray());
// print_r($customer->toJson()). PHP_EOL;

// echo "<hr>";

$CreatePaymentOrder  = [
    'amount'                => 120, //The amount associated with this payment order *100. Must be a positive, non-zero number
    'customerTrns'          => 'Test POST - No End Payment', // This optional parameter adds a friendly description to the payment order that you want to display to the customer on the payment form. It should be a short description of the items/services being purchased.
    'paymentTimeout'        => 1800, //By using this parameter, you can define a different life span for the Payment Order in sec
    'preauth'               => false, //This will hold the selected amount as unavailable (without the customer being charged) for a period of time
    'allowRecurring'        => false, //If this parameter is set to true, recurring payments are enabled so that the initial transaction ID can be used for subsequent payments. https://developer.viva.com/tutorials/payments/create-a-recurring-payment/
    'maxInstallments'       => 0, //The maximum number of installments that the customer can choose for this transaction
    'forceMaxInstallments'  => false, //If this parameter is set to true, the customer will be forced to pay with installments and with the specific number indicated in maxInstallments parameter    
    'paymentNotification'   => true, // If you wish to create a payment order, and then send out an email to the customer to request payment
    'tipAmount'             => 0, //The tip value (if applicable for the customer's purchase) which is already included in the amount of the payment order and marked as tip
    'disableExactAmount'    => false, //If this parameter is set to true, then any amount specified in the payment order is ignored (although still mandatory), and the customer is asked to indicate the amount they will pay
    'disableCash'           => true, //If this parameter is set to true, the customer will not have the option to pay in cash at a Viva Spot
    'disableWallet'         => false, //If this parameter is set to true, the customer will not have the option to pay using their Viva personal account (wallet)
    'cardTokens'            => null, //You can provide the card tokens you have saved on your backend for this customer. The card tokens will then be presented to the customer on Smart Checkout to pay with. For details, view our Handle Card Tokens tutorial.
    'merchantTrns'          => 'This is a short description that helps you uniquely identify the transaction', //This can be either an ID or a short description that helps you uniquely identify the transaction in the viva banking app
    'tags'                  => ['tag1', 'tag2'] //You can add several tags to a transaction that will help in grouping and filtering in the viva banking app
];


$paymentMethods = [0, 8, 21, 29, 34, 35];
$paymentMethodFees  =  [
    'paymentMethodId' => '35',
    'fee' => 550
];


$getOrderJson = '';
try {
    $order = new CreatePaymentOrder($CreatePaymentOrder, $accessToken);
    $order->setCustomer($customer);
    $order->setPaymentMethods($paymentMethods);
    $order->setPaymentMethodsFees($paymentMethodFees);

    $getOrderJson = $order->send();
    // echo $order->getOrderCode();
    // '<a href="'.$order->redirectUrl(PaymentMethods:Enums\PaymentMethods::fromName('VivaWallet')).'" '.$order->getOrderCode().' </a>';
    echo '<a href="' . $order->redirectUrl(PaymentMethods:8) . '" target="blank">';
    // echo '<a href="' . $order->redirectUrl(PaymentMethods: Enums\PaymentMethods::fromName('CreditCard')) . '" target="blank">';
    // echo '<a href="' . $order->redirectUrl(PaymentMethods: Enums\PaymentMethods::fromName('VivaWallet')) . '" target="blank">';
    echo $order->getOrderCode();
    echo '</a>';
} catch (Exception  $e) {
    echo 'An error occured: <b>' . $e->getMessage() . '</b>';
}

// dd($order);











############################# Documentation #############################

///GET ENV PARAMETERS
// $config = new Config('vivaDEMO');
// $url = $config->getEnvConfig('VIVA_ACCOUNT_URL');
// echo $url;
#OR 
// $config = new Config();
// $dbConfig = $config->get('vivaDEMO');
// echo $dbConfig['VIVA_MERCHANT_ID'];


///RUN CURL NATINE
// $curl = new CurlWrapper($url.'/connect/token');
// $curl->addHeader('Content-Type: application/x-www-form-urlencoded');
// $curl->addHeader('User-Agent: PostmanRuntime/0.0.1');
// $curl->addHeader('Accept: */*');
// $curl->setBasicAuth($config->getEnvConfig('VIVA_CLIENT_ID'),$config->getEnvConfig('VIVA_CLIENT_SECRET'));
// $response = $curl->post(array('grant_type' => 'client_credentials'));
// $response = json_encode(json_decode($response,true));
// echo $response;


///GET ACCESS TOKEN
// $accessToken = new AccessToken();
// $accessToken = $accessToken->getAccessToken();
// echo $accessToken;


##ENUMS 
// $Status = Status::PAID;
// echo $Status->type();
// var_dump($Status);

// $type = Enums\Environment::Production;
// echo $type->value;

// $lang = RequestLang::cases();
// dd($lang);

// $lang = RequestLang::from('el-GR');
// dd($lang);




##CUSTOMERS 
// $customer = new Customer(
//     $email = 'example@test.com',
//     $fullName = 'John Doe',
//     $phone = '+306987654321',
//     $countryCode = '',
//     $requestLang = Enums\RequestLang::Greek,
// );
// // print_r($customer->toArray());
// print_r($customer->toJson()). PHP_EOL;


// $requestLang = $_POST['requestLang'] ?? 'el-GR';
// $customer = new Customer(
//     $email = 'example@test.com',
//     $fullName = 'John Doe',
//     $phone = '+306987654321',
//     $countryCode = '',
//     $requestLang = Enums\RequestLang::from($requestLang),
// );
// dd($customer);




##PAYMENT
// $order = new PaymentOrder($CreatePaymentOrder,$accessToken);
// $order->setCustomer($customer);
// $getOrder= $order->getOrder();
// $getOrderJson= $order->toJson();
// echo $getOrderJson;
// $getOrderJson= $order->send();
// dd($getOrderJson);




// require_once '../src/PaymentGateway/VivaPayment/Transaction.php';

// use stadem\PaymentGateway\VivaWallet\Transaction as VivaTransaction;
// var_dump(new VivaTransaction());





// $Transaction = new Transaction(25);
// $Transaction->process();