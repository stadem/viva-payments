<?php


namespace Stadem\VivaPayments\Config;

class Config
{
    private $config;
    private $logger;

    public function __construct(array $customConfig = null)
    {
   

        if( $customConfig===null){
             $paths = [
                dirname(__DIR__, 2) . '/viva-config.php',
                dirname(__DIR__, 5) . '/viva-config.php'
            ];
            $this->config = $this->loadConfigFile($paths);

        }else{

            $this->config = $customConfig;
        }
    }
    
    public function getConfig(): array {
        return $this->config;
    }

    public function get($key)
    {
        return $this->config[$key] ?? null;
    }

    public function getEnvConfig($key)
    {
        $env = $this->config['defaultProvider'];     
        return $this->config[$env][$key] ?? null;
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
