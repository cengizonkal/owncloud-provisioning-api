<?php

namespace Conkal\OwncloudProvisioningApi\Exceptions;

class UsernameAlreadyExistsException extends \Exception
{

    public function __construct($user, $code = 0, \Exception $previous = null)
    {
        $message = "User '{$user}' already exists.";
        parent::__construct($message, $code, $previous);
    }
}