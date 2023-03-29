<?php

namespace Conkal\OwncloudProvisioningApi\Resources;

use Conkal\OwncloudProvisioningApi\OCSResponse;
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

    /**
     * @param $method
     * @param $uri
     * @param  array  $options
     * @return OCSResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request($method, $uri, array $options = [])
    {
        $response = $this->client->request($method, $uri, $options);
        $response = json_decode($response->getBody()->getContents(), true);

        return new OCSResponse($response);


    }

    public function setEndPoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }
}