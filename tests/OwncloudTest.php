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

    public function testUsers()
    {
        $users = $this->owncloud->users()->get();
        $this->assertNotEmpty($users);
    }

    public function testAddUser()
    {
        $this->owncloud->users()->add('anil', '123456', 'test');
        $this->assertTrue(true);
    }

    public function testFindUser()
    {
        $user = $this->owncloud->users()->find('anil');
        $this->assertEquals('anil', $user->id);
    }


    public function testUpdate()
    {
        $this->owncloud->users()->update('anil', 'email', 'aeyupoglu@ciu.edu.tr');

        $this->assertTrue(true);
    }

    public function testDisableUser()
    {
        $this->owncloud->users()->disable('anil');
        $this->assertTrue(true);
    }

    public function testEnableUser()
    {
        $this->owncloud->users()->enable('anil');
        $this->assertTrue(true);
    }

    public function testGetUserGroups()
    {
        $groups = $this->owncloud->users()->groups('anil');
        $this->assertTrue(is_array($groups));
    }

    public function testAddUserToGroup()
    {
        $this->owncloud->users()->addGroup('anil', 'test');
        $this->assertTrue(true);
    }


    public function testCreateGroup()
    {
        $response = $this->owncloud->groups()->create('test');
        $this->assertTrue($response->getStatusCode() == 200);
    }

    public function testGetGroup()
    {
        $group = $this->owncloud->groups()->get('test');
        $this->assertEquals('test', $group->id);
    }


}
