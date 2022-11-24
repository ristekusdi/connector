<?php

namespace RistekUSDI\RBAC\Connector;

use RistekUSDI\RBAC\Connector\ClientRole;
use RistekUSDI\RBAC\Connector\User;
use RistekUSDI\RBAC\Connector\UserRole;

class Connector
{
    private $host, $clientId, $client_secret, $access_token;

    public function __construct()
    {
        $this->host = $_SERVER['CONNECTOR_HOST_URL'];
        $this->clientId = $_SERVER['SSO_CLIENT_ID'];
        $this->client_secret = $_SERVER['SSO_CLIENT_SECRET'];

        if (empty($this->host)) {
            throw new \Exception("Please set CONNECTOR_HOST_URL", 422);
        }

        $url = "{$this->getHost()}/api/login";
        
        $response = curl_request($url, array(
            'header' => array(
               'Content-Type: application/x-www-form-urlencoded'
           ),
           'body' => http_build_query(array(
               'grant_type' => 'client_credentials',
               'client_id' => $this->clientId,
               'client_secret' => $this->client_secret,
           ), "", "&", PHP_QUERY_RFC3986),
        ), 'POST');

        if ($response['code'] === 200) {
            $this->access_token = $response['body']['access_token'];
        } else {
            $this->access_token = '';
        }
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getClientId()
    {
        return $this->clientId;
    }

    public function getClientSecret()
    {
        return $this->client_secret;
    }

    public function getAccessToken()
    {
        return $this->access_token;
    }

    public function getUsers($params = array())
    {
        return (new User($this->getHost(), $this->getAccessToken()))->get($params);
    }

    public function storeUser($params = array())
    {
        return (new User($this->getHost(), $this->getAccessToken()))->store($params);
    }

    public function showUser($username)
    {
        return (new User($this->getHost(), $this->getAccessToken()))->show($username);
    }

    public function updateUser($username, $params = array())
    {
        return (new User($this->getHost(), $this->getAccessToken()))->update($username, $params);
    }

    public function totalUsers($params = array())
    {   
        return (new User($this->getHost(), $this->getAccessToken()))->total($params);
    }

    public function getAssignedUserClientRoles($user_id, $clientId)
    {
        return (new UserRole($this->getHost(), $this->getAccessToken()))
            ->getAssignedUserClientRoles($user_id, $clientId);
    }

    public function syncAssignedUserClientRoles($user_id, $clientId, $current_roles)
    {
        return (new UserRole($this->getHost(), $this->getAccessToken()))
            ->syncAssignedUserClientRoles($user_id, $clientId, $current_roles);
    }

    public function storeClientRole($clientId, $role_name)
    {
        return (new ClientRole($this->getHost(), $this->getAccessToken()))
            ->store($clientId, $role_name);
    }

    public function updateClientRoleName($clientId, $previous_role_name, $current_role_name)
    {
        return (new ClientRole($this->getHost(), $this->getAccessToken()))
            ->updateRoleName($clientId, $previous_role_name, $current_role_name);
    }

    public function deleteClientRole($clientId, $role_name)
    {
        return (new ClientRole($this->getHost(), $this->getAccessToken()))
            ->delete($clientId, $role_name);
    }
}