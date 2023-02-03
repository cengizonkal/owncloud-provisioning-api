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
    private $endpoint = 'owncloud/ocs/v1.php/cloud/users';

    public function __construct(OwncloudClient $client)
    {
        $this->client = $client;
    }


    public function find($id)
    {
        $response = $this->client->request('GET', $this->endpoint.'/'.$id);
        $response = json_decode($response->getBody()->getContents());
        $user = new User();
        $user->enabled = $response->ocs->data->enabled;
        $user->quota = $response->ocs->data->quota;
        $user->email = $response->ocs->data->email;
        $user->displayname = $response->ocs->data->displayname;
        $user->id = $response->ocs->data->displayname;
        return $user;
    }

    public function get()
    {
        $response = $this->client->get($this->endpoint);
        $json = json_decode($response->getBody()->getContents());
        $users = [];
        foreach ($json->ocs->data->users as $userName) {
            $user = new User();
            $user->id = $userName;
            $user->displayname = $userName;
            $users[] = $user;
        }
        return $users;
    }

    public function update($user, $key, $value)
    {
        return $this->client->request('PUT', $this->endpoint.'/'.$user, [
            'form_params' => [
                'key' => $key,
                'value' => $value
            ]
        ]);
    }

    public function create($user, $password, $groups)
    {
        return $this->client->request('POST', $this->endpoint, [
            'form_params' => [
                'userid' => $user,
                'password' => $password,
                'groups' => $groups
            ]
        ]);
    }


    public function setEndPoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }


}