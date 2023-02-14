<?php

namespace Conkal\OwncloudProvisioningApi\Entities;

class User extends Entity
{
    /**
     * @var integer $id Same as displayname
     */
    public $id;
    /**
     * @var boolean $enabled shows if user is enabled or not
     */
    public $enabled;
    public $quota;
    public $email;
    public $displayname;
    public $home;




}