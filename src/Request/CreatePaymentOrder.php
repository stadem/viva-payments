<?php

namespace Stadem\VivaPayments\Request;

use Stadem\VivaPayments\Config\Config;
use Stadem\VivaPayments\Services\CurlWrapper;
use Stadem\VivaPayments\Enums\RequestLang;
use Stadem\VivaPayments\Enums\PaymentMethods;
use Stadem\VivaPayments\Traits\getConfigSettings;


class CreatePaymentOrder
{

    use getConfigSettings;

    private $customer;
    private $order;
    private $accessToken;
    private $vivaOrderCode = null;
    private $response;
    private $paymentMethods;
    private $paymentMethodFees;
    public Config|Array $configObject;

    public function __construct(?array $order, $accessToken,Config|array $configObject)
    {
        $this->configObject=$configObject;
        $this->order = $order;
        $this->accessToken = $accessToken;
    }



    public function setCustomer(Customer $customer)
    {

        if (!($customer instanceof Customer)) {

            return false;
        }

        $this->customer = $customer;

        return $this;
    }


    public function getCustomer()
    {

        return $this->customer->toArray();
    }

    public function toJson(): string
    {
        return json_encode($this->getOrder());
    }


    public function getOrder()
    {
        $config = $this->configObject;
        $order = $this->order;
        $order['sourceCode']  = $config->getEnvConfig('VIVA_SOURCE_CODE');
        // $order['sourceCode']  = $this->getConfigSettings()->getEnvConfig('VIVA_SOURCE_CODE');
        $order['customer'] = $this->getCustomer();
        $order['paymentMethods'] = $this->paymentMethods;
        $order['paymentMethodFees'][] = $this->paymentMethodFees;
        return $order;
    }


    public function getConfig()
    {
        $environment = $this->accessToken->getEnvironment();
        $config = new Config($environment);
        return $config;
    }

    public function getOrderCode()
    {
        return $this->vivaOrderCode;
    }

    public function setOrderCode($vivaOrderCode)
    {
        $this->vivaOrderCode = $vivaOrderCode;
    }

    public function setPaymentMethods(array $paymentMethods)
    {
        $this->paymentMethods = $paymentMethods;
    }

    public function setPaymentMethodsFees($paymentMethodFees)
    {
        $this->paymentMethodFees = $paymentMethodFees;
    }

    public function send()
    {
         $config = $this->configObject;
        //For debugin - Set it to config
        // if ($this->getConfigSettings()->getEnvConfig('VIVA_DEBUG')) {
        if ($config->getEnvConfig('VIVA_DEBUG')) {
            $method = __METHOD__;
            $parentDir = dirname(dirname(dirname(__FILE__)));
            $fp = fopen($parentDir . '/debug_viva.txt', 'a+');
            fwrite($fp, '------- ' . $method . ' -------' . PHP_EOL . $this->toJson() . PHP_EOL . '------------------------------' . PHP_EOL);
            fclose($fp);
        }

        $token = $this->accessToken->getToken();
        $url = $config->getEnvConfig('VIVA_API_URL');
        // $url = $this->getConfigSettings()->getEnvConfig('VIVA_API_URL');
        $curl = new CurlWrapper($url . '/checkout/v2/orders');

        $curl->addHeader('Content-Type: application/json');
        $curl->addHeader('User-Agent: PHPGatewayRuntime/0.0.1');
        $curl->addHeader('Accept: */*');
        $curl->setBearer($token);

        $response = $curl->postRaw($this->toJson());

        $response = json_decode($response, true);
        $this->response = $response;

        if (!isset($response['orderCode'])) {
            throw new \Exception('Invalid orderCode From viva response.');
        }

        $this->vivaOrderCode = $response['orderCode'];
    }


    /**
     * You can ovewrite the color from config by using 
     * $order->redirectUrl(color:'red');
     * 
     * You can set custom language for viva SmartCheckout by using 
     * $order->redirectUrl(lang:Enums\RequestLang::from('en-GB'));
     * 
     * paymentMethod is the selected payment method on smart checkout
     */

    public function redirectUrl(
        ?string $color = null,
        string|RequestLang $lang = null,
        int|PaymentMethods $PaymentMethods = null
    ) {
        $params = '';
        $config = $this->configObject;

        // if (!$color && $this->getConfigSettings()->getEnvConfig('VIVA_SMARTCHECKOUT_COLOR')) {
        //     $params .= "&color=" . $this->getConfigSettings()->getEnvConfig('VIVA_SMARTCHECKOUT_COLOR');
        // }
        if (!$color && $config->getEnvConfig('VIVA_SMARTCHECKOUT_COLOR')) {
            $params .= "&color=" . $config->getEnvConfig('VIVA_SMARTCHECKOUT_COLOR');
        }

        if ($color) $params .= "&color=" . $color;


        if ($lang instanceof RequestLang) {
            $params .= "&lang=" . $lang->value;
        } elseif (is_string($lang)) {
            $params .= "&lang=" . $lang;
        } else {
            $params .= "&lang=el-GR";
        }

        if ($lang instanceof PaymentMethods) {
            $params .= "&paymentMethod=" . $PaymentMethods->value;
        } elseif (is_int($PaymentMethods)) {
            $params .= "&paymentMethod=" . $PaymentMethods;
        }



        $orderCode = $this->vivaOrderCode;
        $url = $config->getEnvConfig('VIVA_URL');
        // $url = $this->getConfigSettings()->getEnvConfig('VIVA_URL');
        return $url . '/web2?ref=' . $orderCode . $params;
    }
}
