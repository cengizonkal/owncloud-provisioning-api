<?php

namespace Conkal\OwncloudProvisioningApi\Exceptions;

class InsufficientPrivilegesException extends \Exception
{
    public function __construct($message = "Insufficient Privileges", $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}