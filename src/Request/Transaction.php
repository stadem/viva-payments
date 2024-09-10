<?php

namespace Stadem\VivaPayments\Request;
use Stadem\VivaPayments\Config\Config;
use Stadem\VivaPayments\Traits\getConfigSettings;
use Stadem\VivaPayments\Services\CurlWrapper;
use  Stadem\VivaPayments\Enums;



class Transaction
{

    use getConfigSettings;

    private $accessToken;
    public Config|Array $configObject;

    public function __construct($accessToken,Config|array $configObject)
    {
        $this->accessToken = $accessToken;
        $this->configObject=$configObject;
    }


    public function getnById($vivaOrdercode)
    {
        return $vivaOrdercode;
    }

    public function getByTransaction($vivaTransaction)
    {
        // https://demo.vivapayments.com/api/transactions/:transaction_id
        if (!$vivaTransaction)   throw new \Exception('Invalid transaction code');
        $config = $this->configObject;
        $url = $config->getEnvConfig('VIVA_URL');
        $curl = new CurlWrapper($url . '/api/transactions/' . $vivaTransaction);
        $curl->addHeader('Content-Type: application/json');
        $curl->addHeader('User-Agent: PHPGatewayRuntime/0.0.1');
        $curl->addHeader('Accept: */*');
        $curl->setBasicAuth($config->getEnvConfig('VIVA_MERCHANT_ID'), $config->getEnvConfig('VIVA_API_KEY'));
        $response = $curl->get();
        // $response= '{"Transactions":[{"Fee":0.00,"BankId":"CLK_ALPHA","ParentId":null,"Switching":false,"Amount":1.20,"StatusId":"F","ChannelId":"245a790d-c98d-4d80-ad97-a9b1efb5771e","MerchantId":"41ebd27c-d39c-418f-875f-433fec10c9ac","ResellerId":null,"InsDate":"2024-06-08T23:30:14.65+03:00","CreatedBy":null,"TipAmount":0.00,"SourceCode":"8541","TransactionId":"f1bad807-15d7-4c41-b578-656e5cf40a16","Commission":0.27,"PanEntryMode":"01","MerchantTrns":"This is a short description that helps you uniquely identify the transaction","CurrencyCode":"978","CustomerTrns":"Test POST - No End Payment","IsManualRefund":false,"TargetPersonId":null,"AcquirerApproved":false,"SourceTerminalId":79504090,"RedeemedAmount":0.00,"AuthorizationId":"208330","TotalInstallments":0,"CurrentInstallment":0,"ClearanceDate":"2024-06-09T02:05:57.6+03:00","ConversionRate":1.0000000,"OriginalAmount":1.2000,"ResellerSourceCode":null,"OriginalCurrencyCode":"978","RetrievalReferenceNumber":"416020208330","Order":{"OrderCode":4694439209472602,"ChannelId":"245a790d-c98d-4d80-ad97-a9b1efb5771e","ResellerId":null,"SourceCode":"8541","Tags":["tag1","tag2"],"RequestLang":"el-GR","ResellerSourceCode":null},"Payment":{"Email":"stademgr@gmail.com","Phone":"+306987654321","ChannelId":"245a790d-c98d-4d80-ad97-a9b1efb5771e","FullName":"Stavros Dem","Installments":0,"RecurringSupport":false},"TransactionType":{"Name":"CardCharge","TransactionTypeId":5},"CreditCard":{"Token":"2BFCB1FD4F000DB41CB5BA76CAFB68D76AB87752","Number":"414746XXXXXX0133","CountryCode":"SG","IssuingBank":"Citibank Singapore Ltd.","CardHolderName":"Lang WoodrowKyprios Testopoulos","ExpirationDate":"2028-01-31T00:00:00","CardType":{"Name":"VISA","CardTypeId":0}}}],"ErrorCode":0,"ErrorText":null,"TimeStamp":"2024-06-09T12:11:27.1514931+03:00","CorrelationId":null,"EventId":0,"Success":true}';
        $response = json_decode($response, true);
        $response['Payment'] = $this->getByTransactionMapper($response);
        return $response;
    }


    public function getByTransactionMapper($response)
    {
        $mapper['TransactionId'] = $response['Transactions'][0]['TransactionId'];
        $mapper['OrderCode'] = $response['Transactions'][0]['Order']['OrderCode'];
        $mapper['PaymentStatus'] = Enums\TransactionStatus::fromValue($response['Transactions'][0]['StatusId']);
        $mapper['TransactionType'] = Enums\TransactionType::fromValue($response['Transactions'][0]['TransactionType']['TransactionTypeId']);
        $mapper['Amount'] = $response['Transactions'][0]['Amount'];
        $mapper['Commission'] = $response['Transactions'][0]['Commission'];
        $mapper['Tags'] = $response['Transactions'][0]['Order']['Tags'];
        return $mapper;
    }


    public function getByTransactionV2($vivaTransaction)
    {
        // https://demo.vivapayments.com/checkout/v2/transactions/:transaction_id
        if (!$vivaTransaction)   throw new \Exception('Invalid transaction code');
        $token = $this->accessToken->getToken();
        $config = $this->configObject;
        $url = $config->getEnvConfig('VIVA_API_URL') . '/checkout/v2/transactions/' . $vivaTransaction;
        $curl = new CurlWrapper($url);
        $curl->addHeader('Content-Type: application/json');
        $curl->addHeader('User-Agent: PHPGatewayRuntime/0.0.1');
        $curl->setBearer($token);
        $response = $curl->get();
        $response = json_decode($response, true);
        $response['PaymentStatus'] =  Enums\TransactionStatus::fromValue($response['statusId']);
        $response['TransactionType'] = Enums\TransactionType::fromValue($response['transactionTypeId']);
        return $response;
    }


    public function getByOrderCode($orderCode)
    {
        // https://demo.vivapayments.com/api/orders/:orderCode
        if (!$orderCode)   throw new \Exception('Invalid transaction code');
        $config = $this->configObject;
        $url = $config->getEnvConfig('VIVA_URL');
        $curl = new CurlWrapper($url . '/api/orders/' . $orderCode);
        $curl->addHeader('Content-Type: application/json');
        $curl->addHeader('User-Agent: PHPGatewayRuntime/0.0.1');
        $curl->addHeader('Accept: */*');
        $curl->setBasicAuth($config->getEnvConfig('VIVA_MERCHANT_ID'), $config->getEnvConfig('VIVA_API_KEY'));
        $response = $curl->get();
        $response = json_decode($response, true);
        $response['orderStatus'] = Enums\OrderStatus::fromValue($response['StateId']);
        // $response['PaymentStatus'] = Enums\TransactionStatus::fromValue($response['StateId']);  
        return $response;
    }


}
