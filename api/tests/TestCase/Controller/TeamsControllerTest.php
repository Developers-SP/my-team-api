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
   
    public function createplayer($id = null){
          $data = [
           'id' => ($id == null)?'76561198121209165':$id
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
     * Test Delete method
     *
     * @return void
     */
    public function testDeleteSuccessfully()
    {
        $this->createplayer();
        $TeamPlayers = TableRegistry::get('TeamPlayers');

         $data = [
            'player_id' => '76561198121209165',
            'name' => 'Vk'
        ];

        $this->post('/teams/insert', $data);
        
        $team_id =$TeamPlayers->find()->select(["team_id"])->where(['player_id' => '76561198121209165'])->toArray();

        $this->delete('/teams/delete/'.$team_id[0]['team_id'].'?player_id=76561198121209165', $data);

        $this->assertResponseCode(200);
        $this->assertResponseContains("Deleted Successfully");

    }

     /**
     * Test Delete Not Permission method
     *
     * @return void
     */
    public function testDeleteNotPermission()
    {
        $this->createplayer('76561198001081692');
        $TeamPlayers = TableRegistry::get('TeamPlayers');

         $data = [
            'player_id' => '76561198121209165',
            'name' => 'Vk'
        ];

        $this->post('/teams/insert', $data);
        
        $team_id =$TeamPlayers->find()->select(["team_id"])->where(['player_id' => '76561198121209165'])->toArray();

         $this->delete('/teams/delete/'.$team_id[0]['team_id'].'?player_id=76561198001081692', $data);

        $this->assertResponseCode(400);
        $this->assertResponseContains("You are not allowed to delete this team");

    }

    /**
     * Test Edit Successfully method
     *
     * @return void
     */
    public function testEditSuccessfully()
    {
        $this->createplayer();
        $TeamPlayers = TableRegistry::get('TeamPlayers');

         $data = [
            'player_id' => '76561198121209165',
            'name' => 'Vk',
            'description' => 'Este Team'
        ];

        $this->post('/teams/insert', $data);
        
        $team_id =$TeamPlayers->find()->select(["team_id"])->where(['player_id' => '76561198121209165'])->toArray();

        $this->put('/teams/edit/'.$team_id[0]['team_id'], $data);

        $this->assertResponseCode(200);
        $this->assertContentType("application/json");
        $this->assertResponseContains("Este Team");

    }


    /**
     * Test Edit Not Permission method
     *
     * @return void
     */
    public function testEditNotPermission()
    {
         $this->createplayer('76561198001081692');
        $TeamPlayers = TableRegistry::get('TeamPlayers');

         $data = [
            'player_id' => '76561198001081692',
            'name' => 'Vk',
            'description' => 'Este Team'
        ];

        $this->post('/teams/insert', $data);
        
        $team_id =$TeamPlayers->find()->select(["team_id"])->where(['player_id' => '76561198121209165'])->toArray();

        $this->put('/teams/edit/'.$team_id[0]['team_id'], $data);

        $this->assertResponseCode(200);
        $this->assertContentType("application/json");
        $this->assertResponseContains("Este Team");

    }
}
