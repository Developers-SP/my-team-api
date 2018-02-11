<?php
namespace App\Test\TestCase\Controller;

use App\Controller\TeamController;
use Cake\TestSuite\IntegrationTestCase;
use App\Model\Entity\TeamPlayers;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\TeamController Test Case
 */
class TeamsControllerTest extends IntegrationTestCase
{



    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = ['app.teams','app.players'];
   
    public function createplayer(){
          $data = [
           'id' => '76561198121209165'
        ];

        $this->post('/players/login', $data);
    }

    /**
     * Test insert method
     *
     * @return void
     */
    public function testInsertOK()
    {
        $this->createplayer();

        $data = [
            'player_id' => '76561198121209165',
            'name' => 'Vk'
        ];

        $this->post('/teams/insert', $data);

        $this->assertResponseCode(200);
        $this->assertContentType("application/json");
        $this->assertResponseContains("teams");
    }

    /**
     * Test insert method
     *
     * @return void
     */
    public function testInsertEmptyName()
    {
        $player_id = $this->createplayer();

        $data = [
            'player_id' => '76561198121209165'
        ];

        $this->post('/teams/insert', $data);

        $this->assertResponseCode(400);
        $this->assertContentType("application/json");
        $this->assertResponseContains("name is required");
    }

     /**
     * Test insert method
     *
     * @return void
     */
    public function testInsertEmptyPlayer_id()
    {
       // $this->createplayer();

        $data = [
            'name' => 'Vk'
        ];

        $this->post('/teams/insert', $data);

        $this->assertResponseCode(400);
        $this->assertContentType("application/json");
        $this->assertResponseContains("player_id is required");
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testDeleteNotPermission()
    {
        $this->createplayer();
        $TeamPlayers = TableRegistry::get('TeamPlayers');
        $team_id =$TeamPlayers->find()->select(["team_id"])->where(['player_id' => '76561198121209165'])->toArray();
      
        $data = [
            'player_id' => '76561198121209165',
            'team_id' => $team_id[0]['team_id']
        ];
        
        $this->delete('/teams/delete', $data);

        $this->assertResponseCode(200);
        

    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
