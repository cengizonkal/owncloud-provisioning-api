<?php

namespace Conkal\OwncloudProvisioningApi\Resources;

use Conkal\OwncloudProvisioningApi\Entities\User;


class Users extends Resource
{

    protected $endpoint = 'owncloud/ocs/v1.php/cloud/users';
    public function find($id)
    {
        $response = $this->request('GET', $this->endpoint.'/'.$id);
        $user = new User();
        $user->id = $id;
        return $user->fill($response['ocs']['data']);
    }

    public function get()
    {
        $response = $this->request('GET', $this->endpoint);
        return array_map(function ($username) {
            $user = new User();
            $user->id = $username;
            $user->displayname = $username;
            return $user;
        }, $response['ocs']['data']['users']);
    }

    public function update($user, $key, $value)
    {
        return $this->request('PUT', $this->endpoint.'/'.$user, [
            'form_params' => [
                'key' => $key,
                'value' => $value
            ]
        ]);
    }

    public function create($user, $password, $groups)
    {
        $this->request('POST', $this->endpoint, [
            'form_params' => [
                'userid' => $user,
                'password' => $password,
                'groups' => $groups
            ]
        ]);
    }

    public function delete($user)
    {
        $this->request('DELETE', $this->endpoint.'/'.$user);
    }

    public function add($user, $password, $groups)
    {
        $this->create($user, $password, $groups);
    }


    public function enable($user)
    {
        $this->request('PUT', $this->endpoint.'/'.$user.'/enable');
    }

    public function disable($user)
    {
        $this->request('PUT', $this->endpoint.'/'.$user.'/disable');
    }

    public function groups($user)
    {
        $response = $this->request('GET', $this->endpoint.'/'.$user.'/groups');
        return $response['ocs']['data']['groups'];
    }

    public function addGroup($user, $group)
    {
        return $this->request('POST', $this->endpoint.'/'.$user.'/groups', [
            'form_params' => [
                'groupid' => $group,
                'userid' => $user
            ]
        ]);
    }


}