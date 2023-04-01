<?php

namespace Conkal\OwncloudProvisioningApi\Exceptions;

class InvalidInputDataException extends \Exception
{

    public function __construct($message = "Invalid Input Data", $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}