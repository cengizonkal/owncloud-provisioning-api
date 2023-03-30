<?php


use Conkal\OwncloudProvisioningApi\Owncloud;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Dotenv\Dotenv;

class OwncloudTest extends TestCase
{
    /**
     * @var Owncloud
     */
    private $owncloud;

    public function setUp()
    {
        //load env variables
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/../.env');
        $this->owncloud = new Owncloud(
            getenv('OWNCLOUD_HOST'), getenv('OWNCLOUD_USERNAME'), getenv('OWNCLOUD_PASSWORD')
        );
    }

    public function testCreateGroup()
    {
        $response = $this->owncloud->groups()->create('test');
        $this->assertTrue(true);
    }

    public function testUsers()
    {
        $users = $this->owncloud->users()->get();
        $this->assertNotEmpty($users);
    }

    public function testAddUser()
    {
        $this->owncloud->users()->add('cengiz', '123456', ['test']);
        $this->assertTrue(true);
    }

    public function testFindUser()
    {
        $user = $this->owncloud->users()->find('cengiz');
        $this->assertEquals('cengiz', $user->id);
    }


    public function testUpdate()
    {
        $this->owncloud->users()->update('cengiz', 'email', 'aeyupoglu@ciu.edu.tr');

        $this->assertTrue(true);
    }

    public function testDisableUser()
    {
        $this->owncloud->users()->disable('cengiz');
        $this->assertTrue(true);
    }

    public function testEnableUser()
    {
        $this->owncloud->users()->enable('cengiz');
        $this->assertTrue(true);
    }

    public function testGetUserGroups()
    {
        $groups = $this->owncloud->users()->groups('cengiz');
        $this->assertTrue(is_array($groups));
    }


    public function testAddUserToGroup()
    {
        $this->owncloud->users()->addToGroup('cengiz', 'test');
        $this->assertTrue(true);
    }

    public function testGetGroup()
    {
        $group = $this->owncloud->groups()->get('test');
        $this->assertEquals('test', $group->id);
    }

    public function testRemoveFromGroup()
    {
        $this->owncloud->users()->removeFromGroup('cengiz', 'test');
        $this->assertTrue(true);
    }

    public function testDeleteUser()
    {
        $this->owncloud->users()->delete('cengiz');
        $this->assertTrue(true);
    }

    public function testDeleteGroup()
    {
        $this->owncloud->groups()->delete('test');
        $this->assertTrue(true);
    }


}
