<?php

namespace Conkal\OwncloudProvisioningApi\Resources;

use Conkal\OwncloudProvisioningApi\Entities\Group;

class Groups extends Resource
{

    protected $endpoint = 'owncloud/ocs/v1.php/cloud/groups';

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
                throw new \Exception('Invalid input data');
            case 102:
                throw new \Exception('Group already exists');
            case 103:
                throw new \Exception('Failed to add the group');
            default:
                throw new \Exception('Unknown error');
        }
    }

    public function create($groupId)
    {
        return $this->add($groupId);
    }

    private function find($groupId)
    {
        $response = $this->request('GET', $this->endpoint.'/'.$groupId);
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
        $groups = [];
        foreach ($response->data['groups'] as $groupName) {
            $group = new Group();
            $group->id = $groupName;
            $group->displayname = $groupName;
            $groups[] = $group;
        }
        return $groups;
    }

    /**
     * @throws \Exception
     */
    public function delete($groupId)
    {
        $response = $this->request('DELETE', $this->endpoint.'/'.$groupId);

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


}