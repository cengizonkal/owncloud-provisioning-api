<?php

namespace Conkal\OwncloudProvisioningApi\Resources;

use Conkal\OwncloudProvisioningApi\Owncloud;
use Conkal\OwncloudProvisioningApi\OwncloudClient;

abstract class Resource
{

    /**
     * @var Owncloud
     */
    protected $client;

    public function __construct(OwncloudClient $client)
    {
        $this->client = $client;
    }
}