<?php

namespace Conkal\OwncloudProvisioningApi;

use GuzzleHttp\ClientInterface;

class Owncloud
{

    private $owncloudClient;

    public function __construct($host, $username, $password, ClientInterface $client)
    {
        $this->owncloudClient = new OwncloudClient([
            'base_uri' => $host,
            'auth' => [$username, $password],
            'headers' => [
                'OCS-APIRequest' => 'true'
            ]
        ]);
    }


    public function users()
    {
        return new Resources\Users($this->owncloudClient);
    }
}