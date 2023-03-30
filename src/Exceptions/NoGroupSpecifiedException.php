<?php

namespace Conkal\OwncloudProvisioningApi\Exceptions;

class NoGroupSpecifiedException extends \Exception
{
    public function __construct($message = "No Group Specified", $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}