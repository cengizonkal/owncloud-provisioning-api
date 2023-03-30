# Owncloud Provisioning API Wrapper

This is a PHP library for interacting with the OwnCloud Provisioning API. It provides a simple and convenient way to manage users and groups within an OwnCloud instance.

## Installation

To install the wrapper, you can use composer by running the following command in your project directory:

```bash
composer require conkal/owncloud-provisioning-api
```
## Usage
To use the wrapper, you first need to include the autoload file from composer:

```php
require 'vendor/autoload.php';
```

Then you can create a new instance of the wrapper:

```php
use Conkal\OwncloudProvisioningApi\Owncloud;

$owncloud = new Owncloud('http://example.com/ocs/v1.php/cloud', 'admin', 'secret');
```
Once you have an Owncloud instance, you can use it to manage users and groups.


### Listing Users

```php
$users = $owncloud->users()->get();
```

### Creating a User

```php
$owncloud->users()->create([
'userid' => 'Frank',
'password' => 'secret',
'email' => 'frank@example.org',
]);
```

### Finding a User
```php
$user = $owncloud->users()->find('user-id');
```

### Update a User
```php
$owncloud->users()->update('user-id', 'email', 'new-email@example.com');
```

### Disable a User
```php
$owncloud->users()->disable('user-id');
```

### Enable a User
```php
$owncloud->users()->enable('user-id');
```

### Add a User to a Group
```php
$owncloud->users()->addToGroup('user-id', 'group-name');
```

### Remove a User from a Group
```php
$owncloud->users()->removeFromGroup('user-id', 'group-name');
```

### Create a Group
```php
$owncloud->groups()->create('group-name');
```

### List Group
```php
$group = $owncloud->groups()->get();
```

For more information on the available methods, please refer to the code.

