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
        $response = $this->owncloud->users()->add('anil', '123456','test');
        $this->assertTrue($response->getStatusCode() == 200);
    }

    public function testFindUser()
    {
        $user = $this->owncloud->users()->find('anil');
        $this->assertEquals('anil', $user->id);
    }


    public function testUpdate()
    {
        $response = $this->owncloud->users()->update('anil','email', 'aeyupoglu@ciu.edu.tr');
        $response->getBody()->getContents();
        $this->assertTrue($response->getStatusCode() == 200);
    }

    public function testDisableUser()
    {
        $response = $this->owncloud->users()->disable('anil');
        $this->assertTrue($response->getStatusCode() == 200);
    }

    public function testEnableUser()
    {
        $response = $this->owncloud->users()->enable('anil');
        $this->assertTrue($response->getStatusCode() == 200);
    }

    public function testGetUserGroups()
    {
        $groups = $this->owncloud->users()->groups('anil');
        $this->assertTrue(is_array($groups));

    }

    public function testAddUserToGroup()
    {
        $response = $this->owncloud->users()->addGroup('anil', 'test');
        $this->assertTrue($response->getStatusCode() == 200);
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
