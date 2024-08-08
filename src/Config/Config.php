<?php


namespace Stadem\VivaPayments\Config;

class Config
{
    private $settings;
    private $config;

    public function __construct($configKey = null)
    {
        $this->settings = require __DIR__ . '/../../config.php';
        if ($configKey) {
            $this->config = $this->get($configKey);
        }else{
            $this->config = $this->settings;
        }
    }

    public function get($key)
    {
        return $this->settings[$key] ?? null;
    }

    public function getEnvConfig($key)
    {
        return $this->config[$key] ?? null;
    }
}