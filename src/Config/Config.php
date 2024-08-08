<?php


namespace Stadem\VivaPayments\Config;

class Config
{
    private $settings;
    private $config;
    private $logger;

    public function __construct($configKey = null)
    {
        
        $paths = [
            dirname(__DIR__, 2) . '/viva-config.php',
            dirname(__DIR__, 5) . '/viva-config.php'];

        $this->settings = $this->loadConfigFile($paths);

        // $this->settings = require dirname(__DIR__, 2) . '/viva-config.php';

        if ($configKey) {
            $this->config = $this->get($configKey);
        } else {
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


    private function loadConfigFile(array $paths)
    {
        foreach ($paths as $path) {
            if (file_exists($path)) {
                if ($this->logger) {
                    $this->logger->info("The file is found on: $path");
                }
                return require $path;
            }
        }

     
        $message = 'The file viva-config.php was not found in any of the specified paths.';

        if ($this->logger) {
            $this->logger->error($message, ['paths' => $paths]);
        }
        throw new \RuntimeException($message);
    }
}
