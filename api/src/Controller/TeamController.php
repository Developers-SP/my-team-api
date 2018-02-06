<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Error\Debugger;
use RestApi\Controller\ApiController;
use RestApi\Utility\JwtToken;
use App\Model\Entity\Team;
use App\Model\Entity\TeamPlayer;
/**
 * Team Controller
 *
 *
 * @method \App\Model\Entity\Team[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TeamController extends ApiController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Steam');
        $this->loadComponent('API');
        $this->loadComponent('Teams');
        $this->loadModel('Team');
        $this->loadModel('TeamPlayer');
        $this->loadModel('Player');
    }
    /**
     * Index method
     *
     * @return Response|null
     */
    public function insert()
    {
        Configure::read('debug',true);

        $this->request->allowMethod('post');

        if(empty($this->request->getData()['name'])){
            $this->httpStatusCode = 400;
            $this->apiResponse['message'] = "name is required";

            return null;
        }

        if(empty($this->request->getData()['player_id'])){
            $this->httpStatusCode = 400;
            $this->apiResponse['message'] = "id_player is required";

            return null;
        }
        
        $team_info = $this->Teams->normalize($this->request->getData());

       
     
        $team = $this->Team->patchEntity($this->Team->newEntity(), $team_info);

        // Saving team 
        if (!$this->Team->save($team)) {
            $this->httpStatusCode = 500;
            $this->apiResponse['message'] = "Unexpected Error";
            return null;
        }

        $player = $this->Player->__get($this->request->getData()['player_id']); 

        $teamPlayer = $this->TeamPlayer->patchEntity($this->TeamPlayer->newEntity(), [
               'team_id'=> $team->id, 
               'player_id' => $player->id
        ]);

        //Saving teamPlayer
        if (!$this->TeamPlayer->save($teamPlayer)) {

                $this->httpStatusCode = 500;
                $this->apiResponse['message'] = "Unexpected Error";
                return null;
        }
        
        $teamPlayer = $this->Team->__get($team->id);
        $this->apiResponse['team'] =  $teamPlayer;
        return null;
        
        
        

    }
}
