<?php

namespace Conkal\OwncloudProvisioningApi\Resources;

use Conkal\OwncloudProvisioningApi\Entities\Group;

class Groups extends Resource
{

    protected $endpoint = 'owncloud/ocs/v1.php/cloud/groups';

    public function add($groupId)
    {
        return $this->request('POST', $this->endpoint, [
            'form_params' => [
                'groupid' => $groupId
            ]
        ]);
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
        $group->users = $response['ocs']['data']['users'];
        return $group;
    }

    public function get($groupId = null)
    {
        if ($groupId) {
            return $this->find($groupId);
        }
        $response = $this->request('GET', $this->endpoint);
        $groups = [];
        foreach ($response['ocs']['data']['groups'] as $groupName) {
            $group = new Group();
            $group->id = $groupName;
            $group->displayname = $groupName;
            $groups[] = $group;
        }
        return $groups;
    }

    public function delete($groupId)
    {
        return $this->request('DELETE', $this->endpoint.'/'.$groupId);
    }


}