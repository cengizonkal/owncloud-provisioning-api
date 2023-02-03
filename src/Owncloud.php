<?php

namespace Conkal\OwncloudProvisioningApi;

use GuzzleHttp\ClientInterface;

class Owncloud
{

    private $owncloudClient;

    public function __construct($host, $username, $password)
    {
        $this->owncloudClient = new OwncloudClient([
            'base_uri' => $host,
            'auth' => [$username, $password],
            'headers' => [
                'OCS-APIRequest' => 'true',
                'Content-Type' => 'application/json'
            ],
            'query' => [
                'format' => 'json'
            ]
        ]);
    }


    public function users()
    {
        return new Resources\Users($this->owncloudClient);
    }



}