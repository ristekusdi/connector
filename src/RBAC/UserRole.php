<?php

namespace RistekUSDI\Connector\RBAC;

class UserRole
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

    public function getAssignedUserClientRoles($user_id, $clientId)
    {
        $url = "{$this->getHost()}/api/v1/users/{$user_id}/clients/{$clientId}/roles";
        
        $response = curl_request($url, array(
            'header' => array(
                "Authorization: Bearer {$this->getAccessToken()}",
                'Content-Type: application/json'
            ),
        ));

        return ($response['code'] === 200) ? $response['body']['data'] : [];
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
}