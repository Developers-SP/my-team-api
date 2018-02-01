<?php 
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\SteamComponent;
use Cake\Controller\Controller;
use Cake\Controller\ComponentRegistry;
use Cake\Event\Event;
use Cake\Http\ServerRequest;
use Cake\Http\Response;
use Cake\TestSuite\TestCase;

class SteamComponentTest extends TestCase
{

    public $component = null;

    public function setUp()
    {
        parent::setUp();
        // Setup our component and fake test controller
        $request = new ServerRequest();
        $response = new Response();
        $this->controller = $this->getMockBuilder('Cake\Controller\Controller')
            ->setConstructorArgs([$request, $response])
            ->setMethods(null)
            ->getMock();
        $registry = new ComponentRegistry($this->controller);
        $this->component = new SteamComponent($registry);
        $event = new Event('Controller.startup', $this->controller);
        $this->component->startup($event);
    }

    public function testGetUserInfo()
    {
        $result = $this->component->getUserInfo('76561198121209165');
        $this->assertArrayHasKey('id', $result);
    }

    public function testGetUserInfoInvalid()
    {
        $result = $this->component->getUserInfo('7612120165');
        $this->assertEmpty($result);
    }

    public function testGetUserInfoEmpty()
    {
        $result = $this->component->getUserInfo();
        $this->assertEmpty($result);
    }

    public function testGetUserStats()
    {
        $result = $this->component->getUserStats('76561198121209165');
        $this->assertNotEmpty($result);
    }

    public function testGetUserStatsInvalid()
    {
        $result = $this->component->getUserStats('7612120165');
        $this->assertEmpty($result);
    }

    public function testGetUserStatsEmpty()
    {
        $result = $this->component->getUserStats();
        $this->assertEmpty($result);
    }

}
