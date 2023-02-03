<?php


use Conkal\OwncloudProvisioningApi\Owncloud;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Dotenv\Dotenv;

class OwncloudTest extends TestCase
{

    public function setUp()
    {
        //load env variables
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/../.env');

    }
    public function testUsers()
    {
        $owncloud = new Owncloud(getenv('OWNCLOUD_BASE_URI'), getenv('OWNCLOUD_USERNAME'), getenv('OWNCLOUD_PASSWORD'), new \GuzzleHttp\Client());
        $users = $owncloud->users()->get();
        var_dump($users);
        $this->assertNotEmpty($users);

    }
}
