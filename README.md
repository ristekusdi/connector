# RBAC Connector
IMISSU2 RBAC Connector

## Requirements

1. Your client type MUST BE confidential to get client secret.
2. Enable Service Account in IMISSU2 to get data from RBAC Connector.
3. Assign roles in Service Accounts tab in client page IMISSU2.

**What is Service Account?**

> A service account is a special type of provider account (e.g. Google, Keycloak, etc) intended to represent a non-human user that needs to authenticate and be authorized to access data in provider APIs. 

## Setup

1. Create file `.env` and set value of `CONNECTOR_HOST_URL`, `SSO_CLIENT_ID`, and  `SSO_CLIENT_SECRET`.

```bash
CONNECTOR_HOST_URL=<imissu2-website>
SSO_CLIENT_ID=<imissu2-website>
SSO_CLIENT_SECRET=<imissu2-website>
```

2. Install package with command below.

```bash
composer require ristekusdi/rbac-connector
```

## Common Use Cases

Here are common use cases that you need to use this package.

### Get Users and Total Users

```php
<?php

use RistekUSDI\RBAC\Connector\Connector;

/**
 * $users_raw return data type array of users with field id, firstName, lastName, email, username, and attributes.
 * 
 * Params: first, max, search, q. All parameters are optional
 * 
 * $start = pagination offset (default 0)
 * $max = maximum result size (default 10)
 * $search = you can search by firstName, lastName, email, and username
 * 
 * Values of parameter 'q' are:
 * - unud_user_type_id:1
 * - unud_user_type_id:2
 * - unud_user_type_id:3
 *
*/
$users_raw = (new Connector())->getUsers(array(
    'first' => $start,
    'max' => $length,
    'search' => $search,
    // key "q" is optional
    'q' => 'unud_user_type_id:2 unud_user_type_id:3'
));

/**
 * $total_users return data type integer
 * 
 * Parameters: search, q. All parameters are optional.
 * 
 * $search = you can search by firstName, lastName, email, and username
 * Values of parameter 'q' are:
 * - unud_user_type_id:1
 * - unud_user_type_id:2
 * - unud_user_type_id:3
 * 
*/
$total_users = (new Connector())->totalUsers(array(
    'search' => $search,
    // key "q" is optional
    'q' => 'unud_user_type_id:2 unud_user_type_id:3'
));
```

### Store user

```php
<?php

use RistekUSDI\RBAC\Connector\Connector;

/**
 * Store user
 * @param $data (user entity)
*/
(new Connector())->storeUser($data);
```

### Show user

```php
<?php

use RistekUSDI\RBAC\Connector\Connector;

/**
 * Show user by username
 * 
 * */
$user = (new Connector())->showUser($username);
```

### Update user

```php
<?php

use RistekUSDI\RBAC\Connector\Connector;

/**
 * Update user by username
 * @param $username, $data (user entity)
 * */
$user = (new Connector())->showUser($username, $data);
```

### Assigned User to Client Role

```php
<?php

use RistekUSDI\RBAC\Connector\Connector;

/**
 * $users_raw return data type array of users with field firstName, lastName, email, username, and attributes.
 * 
 * Params: user_id, client_id, and roles. All parameters are required.
 * 
 * $user_id = id of user NOT id_sso
 * $client_id = client_id from value $_SERVER['SSO_CLIENT_ID'] or config('sso.client_id')
 * $roles = array of role_name
 * 
*/
(new Connector())->syncAssignedUserClientRoles($user_id, $client_id, $roles);
```

### Create a role in a client

```php
<?php

use RistekUSDI\RBAC\Connector\Connector;

/**
 * Store role into client.
 * 
 * Parameters: client_id, role_name. All parameters are required.
 * 
 * $client_id = client_id from value $_SERVER['SSO_CLIENT_ID'] or config('sso.client_id')
 * $role_name = role name
 *
*/
(new Connector())->storeClientRole($client_id, $role_name);
```

### Update role name in a client

```php
<?php

use RistekUSDI\RBAC\Connector\Connector;

/**
 * Update role name in a client.
 * 
 * Parameters: client_id, previous_role_name, current_role_name. All parameters are required.
 * 
 * $client_id = client_id from value $_SERVER['SSO_CLIENT_ID'] or config('sso.client_id')
 * $previous_role_name = previous role name
 * $current_role_name = current role name
 *
*/
(new Connector())->updateClientRoleName($client_id, $previous_role_name, $current_role_name);
```

### Delete role from a client

```php
<?php

use RistekUSDI\RBAC\Connector\Connector;

/**
 * Delete role from client.
 * 
 * Parameters: client_id, role_name. All parameters are required.
 * 
 * $client_id = client_id from value $_SERVER['SSO_CLIENT_ID'] or config('sso.client_id')
 * $role_name = role name
 *
*/
(new Connector())->deleteClientRole($client_id, $role_name);
```