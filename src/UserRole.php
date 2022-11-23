<?php

namespace RistekUSDI\RBAC\Connector;

class UserRole
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