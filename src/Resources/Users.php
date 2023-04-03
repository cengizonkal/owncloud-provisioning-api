<?php

namespace Conkal\OwncloudProvisioningApi\Resources;

use Conkal\OwncloudProvisioningApi\Entities\User;
use Conkal\OwncloudProvisioningApi\Exceptions\GroupDoesNotExistsException;
use Conkal\OwncloudProvisioningApi\Exceptions\InsufficientPrivilegesException;
use Conkal\OwncloudProvisioningApi\Exceptions\InvalidInputDataException;
use Conkal\OwncloudProvisioningApi\Exceptions\NoGroupSpecifiedException;
use Conkal\OwncloudProvisioningApi\Exceptions\UnknownErrorException;
use Conkal\OwncloudProvisioningApi\Exceptions\UserDoesNotExistsException;
use Conkal\OwncloudProvisioningApi\Exceptions\UsernameAlreadyExistsException;

class Users extends Resource
{

    protected $endpoint = 'owncloud/ocs/v1.php/cloud/users';

    public function find($id)
    {
        $response = $this->request('GET', $this->endpoint . '/' . $id);
        if ($response->meta->statusCode != 100) {
            throw new UserDoesNotExistsException($id);
        }
        $user = new User();
        $user->id = $id;
        return $user->fill($response->data);
    }

    public function get()
    {
        $response = $this->request('GET', $this->endpoint);
        if ($response->meta->statusCode != 100) {
            throw new UnknownErrorException('Unknown error');
        }
        return array_map(function ($username) {
            $user = new User();
            $user->id = $username;
            $user->displayname = $username;
            return $user;
        }, $response->data['users']);
    }

    public function update($user, $key, $value)
    {
        $response = $this->request('PUT', $this->endpoint . '/' . $user, [
            'form_params' => [
                'key' => $key,
                'value' => $value
            ]
        ]);
        switch ($response->meta->statusCode) {
            case 100:
                return true;
            case 101:
                throw new UserDoesNotExistsException($user);
            case 102:
                throw new InvalidInputDataException();
            default:
                throw new UnknownErrorException('Unknown error');
        }
    }

    public function create($user, $password, array $groups)
    {
        $response = $this->request('POST', $this->endpoint, [
            'form_params' => [
                'userid' => $user,
                'password' => $password,
                'groups' => $groups
            ]
        ]);
        switch ($response->meta->statusCode) {
            case 100:
                return true;
            case 101:
                throw new InvalidInputDataException();
            case 102:
                throw new UsernameAlreadyExistsException($user);
            case 103:
                throw new UnknownErrorException('Unknown error occurred whilst adding the user');
            case 104:
                throw new GroupDoesNotExistsException(implode(', ', $groups));
            default:
                throw new UnknownErrorException('Unknown error');
        }
    }

    public function delete($user)
    {
        $response = $this->request('DELETE', $this->endpoint . '/' . $user);
        if ($response->meta->statusCode != 100) {
            throw new UnknownErrorException('Unknown error occurred whilst deleting the user');
        }
        return true;
    }

    public function add($user, $password, $groups)
    {
        return $this->create($user, $password, $groups);
    }


    public function enable($user)
    {
        $response = $this->request('PUT', $this->endpoint . '/' . $user . '/enable');
        if ($response->meta->statusCode != 100) {
            throw new UnknownErrorException('Unknown error');
        }
        return true;
    }

    public function disable($user)
    {
        $response = $this->request('PUT', $this->endpoint . '/' . $user . '/disable');
        if ($response->meta->statusCode != 100) {
            throw new UnknownErrorException('Unknown error');
        }
        return true;
    }

    public function groups($user)
    {
        $response = $this->request('GET', $this->endpoint . '/' . $user . '/groups');
        if ($response->meta->statusCode != 100) {
            throw new UnknownErrorException('Unknown error');
        }
        return $response->data['groups'];
    }

    public function addToGroup($user, $group)
    {
        $response = $this->request('POST', $this->endpoint . '/' . $user . '/groups', [
            'form_params' => [
                'groupid' => $group,
                'userid' => $user
            ]
        ]);
        switch ($response->meta->statusCode) {
            case 100:
                return true;
            case 101:
                throw new NoGroupSpecifiedException();
            case 102:
                throw new GroupDoesNotExistsException($group);
            case 103:
                throw new UserDoesNotExistsException($user);
            case 104:
                throw new InsufficientPrivilegesException();
            case 105:
                throw new UnknownErrorException('Failed to add user to group');
            default:
                throw new UnknownErrorException('Unknown error');
        }
    }


    /**
     * @throws \Exception
     */
    public function removeFromGroup($user, $group)
    {
        $response = $this->request('DELETE', $this->endpoint . '/' . $user . '/groups', [
            'form_params' => [
                'groupid' => $group,
                'userid' => $user
            ]
        ]);

        switch ($response->meta->statusCode) {
            case 100:
                return true;
            case 101:
                throw new \Exception('No group specified');
            case 102:
                throw new \Exception('Group does not exist');
            case 103:
                throw new \Exception('User does not exist');
            case 104:
                throw new \Exception('Insufficient privileges');
            case 105:
                throw new \Exception('Failed to remove user from group');
            default:
                throw new \Exception('Unknown error');
        }
    }

    public function edit($user, $key, $value)
    {
        return $this->update($user, $key, $value);
    }
}