<?php

namespace Conkal\OwncloudProvisioningApi\Resources;

use Conkal\OwncloudProvisioningApi\Entities\User;
use Conkal\OwncloudProvisioningApi\Owncloud;
use Conkal\OwncloudProvisioningApi\OwncloudClient;
use http\Client;

class Users extends Resource
{
    /**
     * @var Owncloud
     */
    private $client;
    private $endpoint = 'owncloud/ocs/v1.php/cloud/users?format=json';

    public function __construct(OwncloudClient $client)
    {
        $this->client = $client;
    }

    public function find($id)
    {
        $response = $this->client->request('GET', $this->endpoint.$id);
        return $response->getBody()->getContents();
    }

    public function get()
    {
        $response = $this->client->get($this->endpoint);
        $json = json_decode($response->getBody()->getContents(), true);
        $users = [];
        foreach ($json['ocs']['data']['users'] as $u) {
            $user = new User();
            $user->id = $u;
            $user->displayname = $u;
            $users[] = $user;
        }
        return $users;
    }

}