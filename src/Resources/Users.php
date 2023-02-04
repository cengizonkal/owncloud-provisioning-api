<?php

namespace Conkal\OwncloudProvisioningApi\Resources;

use Conkal\OwncloudProvisioningApi\Entities\User;
use Conkal\OwncloudProvisioningApi\Owncloud;
use Conkal\OwncloudProvisioningApi\OwncloudClient;
use http\Client;

class Users extends Resource
{
    private $endpoint = 'owncloud/ocs/v1.php/cloud/users';

    public function find($id)
    {
        $response = $this->client->request('GET', $this->endpoint . '/' . $id);
        $response = json_decode($response->getBody()->getContents(),true);
        return (new User())->fill($response['ocs']['data']);
    }

    public function get()
    {
        $response = $this->client->request('GET', $this->endpoint);
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
        return $this->client->request('PUT', $this->endpoint . '/' . $user, [
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

    public function delete($user)
    {
        return $this->client->request('DELETE', $this->endpoint . '/' . $user);
    }

    public function setEndPoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }


}