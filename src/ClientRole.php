<?php

namespace RistekUSDI\RBAC\Connector;

class ClientRole
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

    /**
     * Create a role in a client
     * @param $clientId, $role_name
     */
    public function store($clientId, $role_name)
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

    /**
     * Update role name in a client
     * @param $clientId, $previous_role_name, $currernt_role_name
     */
    public function updateRoleName($clientId, $previous_role_name, $current_role_name)
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

    /**
     * Delete a role in a client
     * @param $clientId, $role_name
     */
    public function delete($clientId, $role_name)
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