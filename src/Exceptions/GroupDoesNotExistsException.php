<?php

namespace Conkal\OwncloudProvisioningApi\Exceptions;

class GroupDoesNotExistsException extends \Exception
{
    public function __construct($group, $code = 0, \Exception $previous = null)
    {
        $message = "Group '{$group}' does not exists.";
        parent::__construct($message, $code, $previous);
    }

}