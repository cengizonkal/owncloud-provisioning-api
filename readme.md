# Owncloud Provisioning API Wrapper

A PHP wrapper for the Owncloud Provisioning API.

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
You can then use the wrapper to interact with the Owncloud Provisioning API.

### Creating a User
    
```php
$owncloud->users()->create([
'userid' => 'Frank',
'password' => 'secret',
'email' => 'frank@example.org',
]);
```
### Updating a User

```php
$owncloud->users()->update('Frank','email','franksnewemail@example.org');
```