<?php 
namespace App\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

class PlayersControllerTest extends IntegrationTestCase
{
    public $fixtures = ['app.players'];

    public function testLogin()
    {
        $data = [
            'id' => '76561198121209165'
        ];

        $this->post('/players/login', $data);

        $this->assertResponseCode(200);
        $this->assertContentType("application/json");
        $this->assertResponseContains("id");
        $this->assertResponseContains("OK");
        
    }

    public function testLoginEmpty()
    {
        $data = [];

        $this->post('/players/login', $data);

        $this->assertResponseCode(400);
        $this->assertContentType("application/json");
        $this->assertResponseContains("NOK");
        
    }

    public function testLoginInvalid()
    {
        $data = [
            'id' => '7612120165'
        ];

        $this->post('/players/login', $data);

        $this->assertResponseCode(404);
        $this->assertContentType("application/json");
        $this->assertResponseContains("NOK");
        
    }

    public function testLoginNew()
    {
        $data = [
            'id' => '76561198303910588'
        ];

        $this->post('/players/login', $data);

        $this->assertResponseCode(200);
        $this->assertContentType("application/json");
        $this->assertResponseContains("id");
        $this->assertResponseContains("OK");
        
    }

    public function testEdit()
    {
        $data = [
            'first_name' => 'Pedro',
            'last_name'  => 'Dib',
            'email'     => 'pedrohenrique635@hotmail.com'
        ];

        $this->put('/players/edit/76561198121209165', $data);

        $this->assertResponseCode(200);
        $this->assertContentType("application/json");
        $this->assertResponseContains("OK");
    }

    public function testEditEmpty()
    {
        $data = [
            'first_name' => 'Pedro',
            'last_name'  => 'Dib',
            'email'     => 'pedrohenrique635@hotmail.com'
        ];

        $this->put('/players/edit/', $data);

        $this->assertResponseCode(400);
        $this->assertContentType("application/json");
        $this->assertResponseContains("NOK");
    }

    public function testEditInvalid()
    {
        $data = [
            'first_name' => 'Pedro',
            'last_name'  => 'Dib',
            'email'     => 'pedrohenrique635@hotmail.com'
        ];

        $this->put('/players/edit/7612120165', $data);

        $this->assertResponseCode(404);
        $this->assertContentType("application/json");
        $this->assertResponseContains("NOK");
    }

    public function testUpdateBySteam()
    {
        $this->put('/players/updateBySteam/76561198121209165');

        $this->assertResponseCode(200);
        $this->assertContentType("application/json");
        $this->assertResponseContains("OK");
        
    }

    public function testUpdateBySteamEmpty()
    {
        $this->put('/players/updateBySteam/');

        $this->assertResponseCode(400);
        $this->assertContentType("application/json");
        $this->assertResponseContains("NOK");
        
    }

    public function testUpdateBySteamInvalid()
    {
        $this->put('/players/updateBySteam/7612120165');

        $this->assertResponseCode(404);
        $this->assertContentType("application/json");
        $this->assertResponseContains("NOK");
        
    }

    public function testStats()
    {
        $this->get('/players/stats/76561198121209165');

        $this->assertResponseCode(200);
        $this->assertContentType("application/json");
        $this->assertResponseContains("OK");
        $this->assertResponseContains("\"stats\":");
        
    }

    public function testStatsEmpty()
    {
        $this->get('/players/stats/');

        $this->assertResponseCode(400);
        $this->assertContentType("application/json");
        $this->assertResponseContains("NOK");
        
    }

    public function testStatsInvalid()
    {
        $this->get('/players/stats/7612120165');

        $this->assertResponseCode(404);
        $this->assertContentType("application/json");
        $this->assertResponseContains("NOK");
        
    }

}