<?php

namespace Conkal\OwncloudProvisioningApi\Resources;

use Conkal\OwncloudProvisioningApi\Entities\Group;
use Conkal\OwncloudProvisioningApi\Exceptions\GroupAlreadyExistsException;
use Conkal\OwncloudProvisioningApi\Exceptions\GroupDoesNotExistsException;
use Conkal\OwncloudProvisioningApi\Exceptions\InvalidInputDataException;
use Conkal\OwncloudProvisioningApi\Exceptions\UnknownErrorException;


class Groups extends Resource
{

    protected $endpoint = 'ocs/v1.php/cloud/groups';

    /**
     * @throws \Exception
     */
    public function add($groupId)
    {
        $response = $this->request('POST', $this->endpoint, [
            'form_params' => [
                'groupid' => $groupId
            ]
        ]);

        switch ($response->meta->statusCode) {
            case 100:
                return true;
            case 101:
                throw new InvalidInputDataException();
            case 102:
                throw new GroupAlreadyExistsException($groupId);
            case 103:
                throw new UnknownErrorException('Failed to add the group');
            default:
                throw new UnknownErrorException('Unknown error');
        }
    }

    public function create($groupId)
    {
        return $this->add($groupId);
    }

    private function find($groupId)
    {
        $response = $this->request('GET', $this->endpoint.'/'.$groupId);
        if ($response->meta->statusCode != 100) {
            throw new GroupDoesNotExistsException($groupId);
        }

        $group = new Group();
        $group->id = $groupId;
        $group->displayname = $groupId;
        $group->users = $response->data['users'];
        return $group;
    }

    public function get($groupId = null)
    {
        if ($groupId) {
            return $this->find($groupId);
        }
        $response = $this->request('GET', $this->endpoint);
        if ($response->meta->statusCode != 100) {
            throw new UnknownErrorException('Unknown error');
        }
        $groups = [];
        foreach ($response->data['groups'] as $groupName) {
            $group = new Group();
            $group->id = $groupName;
            $group->displayname = $groupName;
            $groups[] = $group;
        }
        return $groups;
    }


    public function delete($groupId)
    {
        $response = $this->request('DELETE', $this->endpoint.'/'.$groupId);

        switch ($response->meta->statusCode) {
            case 100:
                return true;
            case 101:
                throw new GroupDoesNotExistsException($groupId);
            default:
                throw new UnknownErrorException('Failed to delete the group');
        }
    }

    public function exists($group)
    {
        try {
            $this->find($group);
            return true;
        } catch (GroupDoesNotExistsException $e) {
            return false;
        }
    }


}