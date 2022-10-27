<?php

namespace RistekUSDI\Connector;

class Connector
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

    public function getUsers($params = array())
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

    public function totalUsers($params = array())
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

    public function syncAssignedUserClientRoles($user_id, $clientId, $current_roles)
    {
        $url = "{$this->getHost()}/api/v1/users/{$user_id}/clients/{$clientId}/roles";
        
        return curl_request($url, array(
            'header' => array(
                "Authorization: Bearer {$this->getAccessToken()}",
                'Content-Type: application/json'
            ),
            'body' => json_encode(array(
                'raw_current_roles' => $current_roles,
                '_method' => 'PATCH'
            )),
        ), 'PATCH');
    }

    public function storeClientRole($clientId, $role_name)
    {
        $url = "{$this->getHost()}/api/v1/clients/{$clientId}/roles";
        
        return curl_request($url, array(
            'header' => array(
                "Authorization: Bearer {$this->getAccessToken()}",
                'Content-Type: application/json'
            ),
            'body' => json_encode(array(
                'role_name' => $role_name,
            )),
        ), 'POST');
    }

    public function updateClientRoleName($clientId, $previous_role_name, $current_role_name)
    {
        $url = "{$this->getHost()}/api/v1/clients/{$clientId}/roles";
        
        return curl_request($url, array(
            'header' => array(
                "Authorization: Bearer {$this->getAccessToken()}",
                'Content-Type: application/json'
            ),
            'body' => json_encode(array(
                'previous_role_name' => $previous_role_name,
                'current_role_name' => $current_role_name,
                '_method' => 'PATCH'
            )),
        ), 'PATCH');
    }

    public function deleteClientRole($clientId, $role_name)
    {
        $url = "{$this->getHost()}/api/v1/clients/{$clientId}/roles";
        
        return curl_request($url, array(
            'header' => array(
                "Authorization: Bearer {$this->getAccessToken()}",
                'Content-Type: application/json'
            ),
            'body' => json_encode(array(
                'role_name' => $role_name,
                '_method' => 'DELETE'
            )),
        ), 'DELETE');
    }
}