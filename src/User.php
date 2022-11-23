<?php

namespace RistekUSDI\RBAC\Connector;

class User
{
    private $host, $access_token;

    public function __construct($host, $access_token)
    {
        $this->host = $host;
        $this->access_token = $access_token;
    }

    public function getHost()
    {
        return $this->host;
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

    public function store($params = array())
    {        
        $url = "{$this->getHost()}/api/v1/users";
        
        $response = curl_request($url, array(
            'header' => array(
                "Authorization: Bearer {$this->getAccessToken()}",
                'Content-Type: application/x-www-urlencoded'
            ),
            'body' => http_build_query($params, "", "&",  PHP_QUERY_RFC3986),
        ), 'POST');

        return ($response['code'] === 200) ? $response['body'] : 0;
    }

    public function show($username)
    {        
        $url = "{$this->getHost()}/api/v1/users/{$username}";
        
        $response = curl_request($url, array(
            'header' => array(
                "Authorization: Bearer {$this->getAccessToken()}",
                'Content-Type: application/x-www-urlencoded'
            )
        ));

        return ($response['code'] === 200) ? $response['body'] : 0;
    }

    public function update($username, $params = array())
    {        
        $url = "{$this->getHost()}/api/v1/users/{$username}";
        
        $response = curl_request($url, array(
            'header' => array(
                "Authorization: Bearer {$this->getAccessToken()}",
                'Content-Type: application/x-www-urlencoded'
            ),
            'body' => http_build_query($params, "", "&",  PHP_QUERY_RFC3986),
        ), 'PATCH');

        return ($response['code'] === 200) ? $response['body'] : 0;
    }
}