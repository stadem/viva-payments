<?php
namespace Stadem\VivaPayments\Services;
use Stadem\VivaPayments\Traits\getConfigSettings;

class CurlWrapper {

    use getConfigSettings;

    private $ch;
    private $url;
    private $headers = array();
    private $statusCode;

    public function __construct($url) {
        $this->url = $url;
        $this->ch = curl_init($this->url);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true); 
    }

    public function addHeader($header) {
        $this->headers[] = $header;
    }

    public function get($params = array()) {
        $this->setOption(CURLOPT_HTTPGET, true);
        return $this->execute();
    }

    public function post($params = array()) {
        $this->setOption(CURLOPT_POST, true);
        $this->setOption(CURLOPT_POSTFIELDS, http_build_query($params));
        return $this->execute();
    }

    public function postRaw($params) {
        $this->setOption(CURLOPT_POST, true);
        $this->setOption(CURLOPT_POSTFIELDS, $params);
        // $this->addHeader('Content-Type: application/json');
        // $this->addHeader('User-Agent: PostmanRuntime/0.0.1');
        return $this->execute();
    }

    public function put($params = array()) {
        $this->setOption(CURLOPT_CUSTOMREQUEST, 'PUT');
        $this->setOption(CURLOPT_POSTFIELDS, http_build_query($params));
        return $this->execute();
    }

    public function delete($params = array()) {
        $this->setOption(CURLOPT_CUSTOMREQUEST, 'DELETE');
        $this->setOption(CURLOPT_POSTFIELDS, http_build_query($params));
        return $this->execute();
    }

    public function setBasicAuth($username, $password) {
        $auth_string = base64_encode("$username:$password");
        $this->addHeader("Authorization: Basic $auth_string");
    }

    public function setBearer($token) { 
        $this->addHeader("Authorization: Bearer $token");
    }
    
    private function setOption($option, $value) {
        curl_setopt($this->ch, $option, $value);
    }

    private function execute() {
      
        //For debuging 
       if ($this->getCurlDebugIsEnable()){
        $parentDir = dirname(dirname(dirname(__FILE__)));
        $fp = fopen($parentDir.'/debug_viva_curl.txt', 'w');
        curl_setopt($this->ch, CURLOPT_VERBOSE, 1);
        curl_setopt($this->ch, CURLOPT_STDERR, $fp);
        }

        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);

        $response = curl_exec($this->ch);

        //For debuging 
        if ($this->getCurlDebugIsEnable()){
            $method = __METHOD__;
            $parentDir = dirname(dirname(dirname(__FILE__)));
            $fp = fopen($parentDir . '/debug_viva_curl_response.txt', 'a+');
            fwrite($fp, '------- '. $method.' -------'.PHP_EOL. $response.PHP_EOL.'------------------------------'.PHP_EOL);
            fclose($fp);
        } 

        if ($response === false) {    
            $errorCode = curl_errno($this->ch);
            $errorMsg = curl_error($this->ch);




            throw new \Exception('Curl error: ' . $errorMsg.' '. $errorCode);        
        }
        
        $data = json_decode($response, true);
        $this->statusCode = $data[0]['status'] ?? curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
        return $response;
    }

    public function getStatusCode():int {
        return $this->statusCode;
    }

    public function close() {
        curl_close($this->ch);
    }
}