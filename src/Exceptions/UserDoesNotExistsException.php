<?php

namespace Conkal\OwncloudProvisioningApi\Exceptions;

class UserDoesNotExistsException extends \Exception
{

    public function __construct($user, $code = 0, \Exception $previous = null)
    {
        $message = "User '{$user}' does not exists.";
        parent::__construct($message, $code, $previous);
    }

}