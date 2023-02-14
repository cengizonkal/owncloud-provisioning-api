<?php

namespace Conkal\OwncloudProvisioningApi\Resources;

use Conkal\OwncloudProvisioningApi\Entities\Group;
use Conkal\OwncloudProvisioningApi\Owncloud;
use Conkal\OwncloudProvisioningApi\OwncloudClient;


class Groups extends Resource
{

    private $endpoint = 'owncloud/ocs/v1.php/cloud/groups';

    public function add($groupId)
    {
        return $this->client->request('POST', $this->endpoint, [
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
        $response = $this->client->request('GET', $this->endpoint.'/'.$groupId);
        $response = json_decode($response->getBody()->getContents(), true);
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
        $response = $this->client->get($this->endpoint);
        $json = json_decode($response->getBody()->getContents(), true);
        $groups = [];
        foreach ($json['ocs']['data']['groups'] as $groupName) {
            $group = new Group();
            $group->id = $groupName;
            $group->displayname = $groupName;
            $groups[] = $group;
        }
        return $groups;
    }

    public function delete($groupId)
    {
        return $this->client->request('DELETE', $this->endpoint.'/'.$groupId);
    }


}