<?php

namespace Conkal\OwncloudProvisioningApi\Exceptions;

class FailedToRemoveUserFromGroupException extends \Exception
{

    public function __construct($user, $group, $code = 0, \Exception $previous = null)
    {
        $message = "Failed to remove user '{$user}' from group '{$group}'.";
        parent::__construct($message, $code, $previous);
    }

}