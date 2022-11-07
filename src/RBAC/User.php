<?php

namespace RistekUSDI\Connector\RBAC;

class User
{
    private $host, $access_token;

    public function __construct($access_token)
    {
        $this->host = isset($_SERVER['CONNECTOR_HOST_URL']) ? $_SERVER['CONNECTOR_HOST_URL'] : 'http://localhost:8000';
        $this->access_token = $access_token;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getClientId()
    {
        return $this->clientId;
    }

    public function getAccessToken()
    {
        return $this->access_token;
    }

    public function get($params = array())
    {
        $query = isset($params) ? http_build_query($params) : '';
        $url = "{$this->getHost()}/api/v1/users?{$query}";
        
        $response = curl_request($url, array(
            'header' => array(
                "Authorization: Bearer {$this->getAccessToken()}"
            ),
        ));
        
        return ($response['code'] === 200) ? $response['body']['data'] : [];
    }

    public function total($params = array())
    {        
        $query = isset($params) ? http_build_query($params) : '';
        $url = "{$this->getHost()}/api/v1/users/count?{$query}";
        
        $response = curl_request($url, array(
            'header' => array(
                "Authorization: Bearer {$this->getAccessToken()}"
            ),
        ));

        return ($response['code'] === 200) ? $response['body'] : 0;
    }
}