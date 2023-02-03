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
}
