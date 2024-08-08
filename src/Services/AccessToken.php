<?php

namespace Stadem\VivaPayments\Services;
use Stadem\VivaPayments\Config\Config;
use Stadem\VivaPayments\Services\CurlWrapper;

class AccessToken
{

    private $accessToken;
    private $environment;
    private $statusCode;

    public function __construct(string $environment = null){

        if($environment===null){
            $config = new Config();
            $environment = $config->getEnvConfig('defaultProvider'); 
        }

        if ($environment !== 'vivaDEMO' && $environment !== 'vivaPROD') {
            throw new \InvalidArgumentException('Invalid environment value {'.$environment.'}. It should be either "vivaDEMO" or "vivaPROD".');
        }
        $this->environment = $environment;   

    }

    public function getAccessToken(): string
    {
        $config = new Config($this->environment);
        $url = $config->getEnvConfig('VIVA_ACCOUNT_URL');
        $curl = new CurlWrapper($url.'/connect/token');
        $curl->addHeader('Content-Type: application/x-www-form-urlencoded');
        $curl->addHeader('User-Agent: PHPGatewayRuntime/0.0.1');
        $curl->addHeader('Accept: */*');
        $curl->setBasicAuth($config->getEnvConfig('VIVA_CLIENT_ID'),$config->getEnvConfig('VIVA_CLIENT_SECRET'));
        $response = $curl->post(array('grant_type' => 'client_credentials'));   
        $this->statusCode = $curl->getStatusCode();
        $response = json_decode($response,true);

        $this->accessToken = $response['access_token'];
        return $this->accessToken;
    }

    public function getWebhookValidationToken() : array
    {
        $config = new Config($this->environment);
        $url = $config->getEnvConfig('VIVA_URL');
        $curl = new CurlWrapper($url.'/api/messages/config/token');
        $curl->addHeader('Content-Type: application/x-www-form-urlencoded');
        $curl->addHeader('User-Agent: PHPGatewayRuntime/0.0.1');
        $curl->addHeader('Accept: */*');
        $curl->setBasicAuth($config->getEnvConfig('VIVA_MERCHANT_ID'),$config->getEnvConfig('VIVA_API_KEY'));

        $response = $curl->get();   

        $response = json_decode($response,true);
        return $response;
    }



    public function getEnvironment(): string {
        return $this->environment;
    }

    
    public function getToken(): string {
        return $this->accessToken;
    }


    public function getStatusCode():int {
        return $this->statusCode;
    }

    public function refresh(): self
    {
        return $this;
    }


}
