<?php namespace ilazaridis\skroutz;

class Client
{
    const OATH2_LINK = 'https://www.skroutz.gr/oauth2/token?client_id=%s&client_secret=%s&grant_type=client_credentials&scope=public';
    private $identifier, $secret;
    public $token;

    function __construct($identifier, $secret)
    {
        $this->identifier = $identifier;
        $this->secret = $secret;
        if (!in_array('curl', get_loaded_extensions())) {
            throw new \Exception('Curl module is not enabled!');
        }
        $this->token = $this->generateToken($this->identifier, $this->secret);
    }

    private function generateToken($identifier, $secret) : string
    {
        $oathUrl = sprintf(self::OATH2_LINK, $identifier, $secret);
        $ch = curl_init($oathUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        $_response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($_response, true);
        return $response['access_token'] ?? '';
    }

    public function __call($name, $arguments)
    {
        $class = '\\ilazaridis\\skroutz\\resources\\'.ucwords($name);
        $resourceId = isset($arguments[0]) ? '/'.$arguments[0] : '';
        if (class_exists($class)) {
            return new $class($this->token, $resourceId);
        }
        throw new \Exception("Undefined resource [{$name}] called.");
    }
}