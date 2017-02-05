<?php namespace ilazaridis\skroutz\resources;

class Api
{
    private $token;
    const API_URL = 'http://api.skroutz.gr';

    public function __construct($token, string $id = '')
    {
        $this->token = $token;
        $this->url .= $id;
        return $this;
    }

    public function fetch(bool $decode = true, string $apiVersion = '3.1')
    {
        $ch = curl_init(self::API_URL.$this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,
                    CURLOPT_HTTPHEADER,
                    [
                        'Accept: application/vnd.skroutz+json; version='.$apiVersion,
                        'Authorization: Bearer '.$this->token
                    ]
        );
        $response = curl_exec($ch);
        curl_close($ch);
        if (empty($response)) {
            throw new \Exception("Resource does not exist");
        }
        return $decode ? json_decode($response, true) : $response;
    }

    public function __call($name, $arguments)
    {
        $parameters = '';
        $querySegment = [];
        if (!empty($arguments)) {
            if ($name === 'params') {
                $multipleValues = array_filter($arguments[0], function($v) {
                    return strpos($v, ',');
                });

                foreach ($multipleValues as $k => $v) {
                    $valuesToArray = explode(',', $v);
                    $querySegment[] = array_map(function ($_v) use ($k) {
                        return $k.'='.trim($_v);
                    }, $valuesToArray);
                }

                $argumentsWithoutParams = $multipleValues ? array_diff($arguments[0], $multipleValues) : $arguments[0];
                $params = array_map(function($e) {
                    return implode('&', $e);
                }, $querySegment);
                $delimiter = (!empty($params) && !empty($argumentsWithoutParams)) ? '&' : '';
                $parameters = '?'.http_build_query($argumentsWithoutParams, '', '&').$delimiter.implode('&', $params);
            } else {
                $parameters = '/'.$arguments[0];
            }
        }
        $method = $name === 'params' ? '' : '/'.$name;
        $this->url .= $method.$parameters;
        return $this;
    }
}