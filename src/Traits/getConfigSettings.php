<?php

namespace Stadem\VivaPayments\Traits;
use Stadem\VivaPayments\Config\Config;

trait getConfigSettings
{
       public function getConfigSettings() {
        $environment = $this->accessToken->getEnvironment();
        $config = new Config($environment);
        return $config;
        }

        public function getCurlDebugIsEnable() {

        $config = new Config();     
        return $config->get('curlDebug');

        } 
    
}