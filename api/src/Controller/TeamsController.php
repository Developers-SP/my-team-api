<?php

namespace App\Controller;

use RestApi\Controller\ApiController;
use RestApi\Utility\JwtToken;
use App\Model\Entity\Teams;
use App\Model\Entity\TeamPlayers;
/**
 * Team Controller
 *
 *
 * @method \App\Model\Entity\Team[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TeamsController extends ApiController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Steam');
        $this->loadComponent('API');
        $this->loadComponent('Team');
        $this->loadModel('TeamPlayers');
        $this->loadModel('Players');
        $this->loadComponent('Validation', [
            'api_resource' => $this
        ]);
    }
    /**
     * Insert method
     *
     * @return Response|null
     */
    public function insert()
    {        
        $this->request->allowMethod('post');

         // Validating if name team is being sended
        if($this->Validation->is_emptyID($this->request->getData()['name'], [ 'status_code' => 400, 'message' => "name is required" ]))
            return null;

         // Validating if player_id is being sended
        if($this->Validation->is_emptyID($this->request->getData()['player_id'], [ 'status_code' => 400, 'message' => "player_id is required" ]))
            return null;
        
        $team_info = $this->Team->normalize($this->request->getData());
     
        $team = $this->Teams->patchEntity($this->Teams->newEntity(), $team_info);

        if($this->Validation->was_saved($this->Teams->save($team))) {
            $player = $this->Players->__get($this->request->getData()['player_id']); 

            $teamPlayer = $this->TeamPlayers->patchEntity($this->TeamPlayers->newEntity(), [
                   'team_id'=> $team->id, 
                   'player_id' => $player->id,
                   'is_owner' => True
            ]);

                 //Saving teamPlayer 
            if($this->Validation->was_saved($this->TeamPlayers->save($teamPlayer))) {
                $this->apiResponse['teams'] =  $this->Teams->__get($team->id);
                return null;
            }
             
        }
              
    }

        /**
     * Delete method
     *
     * @return Response|null
     */
    public function delete(){
        $this->request->allowMethod('delete');

        $this->httpStatusCode = 400;

    }
}
