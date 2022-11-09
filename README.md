# Connector
Connector for IMISSU2 Role Based Access Control

# Setup

Create file `.env` and set value of `CONNECTOR_HOST_URL` with IMISSU2 website.

```bash
CONNECTOR_HOST_URL=<imissu2-website>
```

## Common Use Cases

So far, here are common use cases that you need to use this package.

### Get Users and Total Users

```php
<?php

use RistekUSDI\Connector\RBAC\User as ConnectorRBACUser;

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
 * The value of $access_token can be get with these command:
 * - Laravel framework: session()->get('_sso_token')['access_token']) 
 * - Non Laravel framework: $_SESSION['_sso_token']['access_token']
*/
$users_raw = (new ConnectorRBACUser($access_token)->get(array(
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
 * The value of $access_token can be get with these command:
 * - Laravel framework: session()->get('_sso_token')['access_token']) 
 * - Non Laravel framework: $_SESSION['_sso_token']['access_token']
*/
$total_users = (new ConnectorRBACUser($access_token)->total(array(
    'search' => $search,
    // key "q" is optional
    'q' => 'unud_user_type_id:2 unud_user_type_id:3'
));
```

### Assigned User to Client Role

```php
<?php

use RistekUSDI\Connector\RBAC\UserRole as ConnectorRBACUserRole;

/**
 * $users_raw return data type array of users with field firstName, lastName, email, username, and attributes.
 * 
 * Params: user_id, client_id, and roles. All parameters are required.
 * 
 * $user_id = id of user NOT id_sso
 * $client_id = client_id from value $_SERVER['SSO_CLIENT_ID'] or config('sso.client_id')
 * $roles = array of role_name
 * 
 * 
 * The value of $access_token can be get with these command:
 * - Laravel framework: session()->get('_sso_token')['access_token']) 
 * - Non Laravel framework: $_SESSION['_sso_token']['access_token']
*/
(new ConnectorRBACUserRole($access_token)->syncAssignedUserClientRoles($user_id, $client_id, $roles);
```

### Create Role

```php
<?php

use RistekUSDI\Connector\RBAC\ClientRole as ConnectorRBACRole;

/**
 * Store role into client.
 * 
 * Parameters: client_id, role_name. All parameters are required.
 * 
 * $client_id = client_id from value $_SERVER['SSO_CLIENT_ID'] or config('sso.client_id')
 * $role_name = role name
 * 
 * The value of $access_token can be get with these command:
 * - Laravel framework: session()->get('_sso_token')['access_token']) 
 * - Non Laravel framework: $_SESSION['_sso_token']['access_token']
*/
(new ConnectorRBACRole($access_token))->storeClientRole($client_id, $role_name);
```

### Update Role

```php
<?php

use RistekUSDI\Connector\RBAC\ClientRole as ConnectorRBACRole;

/**
 * Update role client.
 * 
 * Parameters: client_id, previous_role_name, current_role_name. All parameters are required.
 * 
 * $client_id = client_id from value $_SERVER['SSO_CLIENT_ID'] or config('sso.client_id')
 * $previous_role_name = previous role name
 * $current_role_name = current role name
 * 
 * The value of $access_token can be get with these command:
 * - Laravel framework: session()->get('_sso_token')['access_token']) 
 * - Non Laravel framework: $_SESSION['_sso_token']['access_token']
*/
(new ConnectorRBACRole($access_token))->updateClientRoleName($client_id, $previous_role_name, $current_role_name);
```

### Delete Role

```php
<?php

use RistekUSDI\Connector\RBAC\ClientRole as ConnectorRBACRole;

/**
 * Delete role from client.
 * 
 * Parameters: client_id, role_name. All parameters are required.
 * 
 * $client_id = client_id from value $_SERVER['SSO_CLIENT_ID'] or config('sso.client_id')
 * $role_name = role name
 * 
 * The value of $access_token can be get with these command:
 * - Laravel framework: session()->get('_sso_token')['access_token']) 
 * - Non Laravel framework: $_SESSION['_sso_token']['access_token']
*/
(new ConnectorRBACRole($access_token))->deleteClientRole($client_id, $role_name);
```