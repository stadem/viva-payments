<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Stadem\VivaPayments\Services\AccessToken;
use Stadem\VivaPayments\Request\Transaction;
use Stadem\VivaPayments\Enums;
use Stadem\VivaPayments\Config\Config;

// echo 'hello from proxy';

try {
    // $accessToken = new AccessToken(environment: 'vivaDEMO');
    // $webHookVerification = $accessToken->getWebhookValidationToken();

    // echo json_encode($webHookVerification);
    // dump($Token);


    ## LOG THE WEBHOOK ##
    // $file_name = '../src/debug_webhook-payment-created.txt';
    // $request_data_json ='';    
    // $raw_post_data = file_get_contents('php://input');
    // if (!empty($raw_post_data)) {$request_data_json .= $raw_post_data;}    
    // file_put_contents($file_name, $request_data_json.PHP_EOL, FILE_APPEND);
    // echo 'ok';

    ##Validate if the webhook is paid
    $response = '{"Url":"https://vivapayment.sec.gr/webhookproxy.php?type=newpayment","EventData":{"Moto":false,"BinId":41,"IsDcc":false,"Ucaf":"AJkBBpIUkwAAAAB4l4FidQcEZSM=","Email":"stademgr@gmail.com","Phone":"+306987654321","BankId":"CLK_ALPHA","Systemic":false,"Switching":false,"ParentId":null,"Amount":1.20,"ChannelId":"245a790d-c98d-4d80-ad97-a9b1efb5771e","TerminalId":79504090,"MerchantId":"41ebd27c-d39c-418f-875f-433fec10c9ac","OrderCode":2593699567872608,"ProductId":null,"StatusId":"F","FullName":"Stavros Dem","ResellerId":null,"DualMessage":false,"InsDate":"2024-06-10T09:55:07.957","TotalFee":0.0,"CardToken":"2BFCB1FD4F000DB41CB5BA76CAFB68D76AB87752","CardNumber":"414746XXXXXX0133","Descriptor":null,"TipAmount":0.0,"SourceCode":"8541","SourceName":"localhost Test payment","Latitude":null,"Longitude":null,"CompanyName":null,"TransactionId":"19e058a5-2b5b-4b4e-92d0-de9a73c8b3ae","CompanyTitle":null,"PanEntryMode":"01","ReferenceNumber":212711,"ResponseCode":"00","CurrencyCode":"978","OrderCulture":"el-GR","MerchantTrns":"This is a short description that helps you uniquely identify the transaction","CustomerTrns":"Test POST - No End Payment","IsManualRefund":false,"TargetPersonId":null,"TargetWalletId":null,"AcquirerApproved":false,"LoyaltyTriggered":false,"TransactionTypeId":5,"AuthorizationId":"212711","TotalInstallments":0,"CardCountryCode":"SG","CardIssuingBank":"Citibank Singapore Ltd.","RedeemedAmount":0.0,"ClearanceDate":null,"ConversionRate":1.0000000,"CurrentInstallment":0,"OriginalAmount":1.2000,"Tags":["tag2","tag1"],"BillId":null,"ConnectedAccountId":null,"ResellerSourceCode":null,"ResellerSourceName":null,"MerchantCategoryCode":null,"ResellerCompanyName":null,"CardUniqueReference":"2BFCB1FD4F000DB41CB5BA76CAFB68D76AB87752","OriginalCurrencyCode":"978","ExternalTransactionId":null,"ResellerSourceAddress":null,"CardExpirationDate":"2026-11-30T00:00:00","ServiceId":null,"RetrievalReferenceNumber":"416206212711","AssignedMerchantUsers":[],"AssignedResellerUsers":[],"CardTypeId":0,"ResponseEventId":null,"ElectronicCommerceIndicator":"5","OrderServiceId":4,"ApplicationIdentifierTerminal":null,"IntegrationId":null,"DigitalWalletId":null,"DccSessionId":null,"DccMarkup":null,"DccDifferenceOverEcb":null},"Created":"2024-06-10T06:55:08.3492636Z","CorrelationId":"24-162-AEF1BDA5","EventTypeId":1796,"Delay":null,"MessageId":"31eb6552-2e6f-44b7-b63c-e84fec68e65f","RecipientId":"41ebd27c-d39c-418f-875f-433fec10c9ac","MessageTypeId":512}';
    $response = json_decode($response, true);

    $config = new Config();
    $accessToken = new AccessToken($config); 
    $Token = $accessToken->getAccessToken();   
    $transaction = new Transaction($Token,   $config );


    ##Validate the webhook if the transaction is paid. 
    //Get from EventTypeId (1796) the EventTypeName (TransactionPaymentCreated)
    $response['EventTypeName'] = Enums\WebhookEventType::fromValue($response['EventTypeId']);
    $vivaTransaction = $response['EventData']['TransactionId'];
    $validateTransaction = $transaction->getByTransaction($vivaTransaction);

    //Get the statuses        
    $PaymentStatus = $validateTransaction['Payment']['PaymentStatus'];
    echo  $PaymentStatus == 'PaymentSuccessful' ? $PaymentStatus  : 'The status is' . $PaymentStatus;

    dump($validateTransaction);
    dump($response);

} catch (Exception  $e) {
    echo 'An error occured: <b>' . $e->getMessage() . '</b>';
}

