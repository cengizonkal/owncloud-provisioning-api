<?php

namespace Conkal\OwncloudProvisioningApi\Exceptions;

class GroupAlreadyExistsException extends \Exception
{
    public function __construct($group, $code = 0, \Exception $previous = null)
    {
        $message = "Group '{$group}' already exists.";
        parent::__construct($message, $code, $previous);
    }

}