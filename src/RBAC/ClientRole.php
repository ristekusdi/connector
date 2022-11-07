<?php

namespace RistekUSDI\Connector\RBAC;

class ClientRole
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