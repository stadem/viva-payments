<?php

namespace Stadem\VivaPayments\Traits;
use Stadem\VivaPayments\Config\Config;

trait getConfigSettings
{
       public function getConfigSettings() {
        if (!property_exists($this, 'accessToken')) {
                throw new \Exception('Property $accessToken does not exist');
            }
        $environment = $this->accessToken->getEnvironment();
        $config = new Config($environment);
        return $config;
        }

        public function getCurlDebugIsEnable() {

        $config = new Config();     
        return $config->get('curlDebug');

        } 
    
}