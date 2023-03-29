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
    protected $endpoint;

    public function __construct(OwncloudClient $client)
    {
        $this->client = $client;
    }

    public function request($method, $uri, array $options = [])
    {
        $response = $this->client->request($method, $uri, $options);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function setEndPoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }
}