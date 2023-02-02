<?php

namespace Conkal\OwncloudProvisioningApi;

use GuzzleHttp\ClientInterface;

class Owncloud
{
    private $host;
    private $username;
    private $password;
    private $client;

    public function __construct($host, $username, $password, ClientInterface $client)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->client = $client;
    }


    public function users()
    {
        $response = $this->client->request('GET', $this->host . '/ocs/v2.php/cloud/users', [
            'auth' => [$this->username, $this->password],
            'headers' => [
                'OCS-APIRequest' => 'true',
                'Accept' => 'application/json',
            ],
        ]);
        return json_decode($response->getBody()->getContents(), true);

    }
}