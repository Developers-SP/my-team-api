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
        $this->loadComponent('Validator',[
            'api_resource' => $this
        ]);
        $this->loadComponent('Paginator');
    }
    /**
     * Insert method
     *
     * @return Response|null
     */
    public function insert()
    {        
        $this->request->allowMethod('post');

        $name = $this->Validator->__getRequestKey('name');

        $player_id = $this->Validator->__getRequestKey('player_id');
         // Validating if name team is being sended
        if($this->Validator->is_emptyID($name , [ 'status_code' => 400, 'message' => "name is required" ]))
            return null;

         // Validating if player_id is being sended
        if($this->Validator->is_emptyID($player_id, [ 'status_code' => 400, 'message' => "player_id is required" ]))
            return null;
        
        $team_info = $this->Team->normalize($this->request->getData());
     
        $team = $this->Teams->patchEntity($this->Teams->newEntity(), $team_info);

        if($this->Validator->was_saved($this->Teams->save($team))) {
            $player = $this->Players->__get($this->request->getData()['player_id']); 

            $teamPlayer = $this->TeamPlayers->patchEntity($this->TeamPlayers->newEntity(), [
                   'team_id'=> $team->id, 
                   'player_id' => $player->id,
                   'is_owner' => True
            ]);

                 //Saving teamPlayer 
            if($this->Validator->was_saved($this->TeamPlayers->save($teamPlayer))) {
                $this->apiResponse['teams'] =  $this->Teams->__get($team->id);
            }
             
        }
              
    }

    /**
     * Delete method
     *
     * @return Response|null
     */
    public function delete($id){
        $this->request->allowMethod('delete');


        $team_id = $id;

        $player_id = $this->request->query['player_id'];

        // Validating if player is owner the team 
        if($this->TeamPlayers->getIsOwner($player_id, $team_id)){
                $this->TeamPlayers->deleteTeamPlayers($player_id, $team_id); 
                if($this->Teams->deleteTeams($team_id)){
                    $this->apiResponse['message'] =  'Deleted Successfully';
                    $this->httpStatusCode = 200;
                } else{
                    $this->apiResponse['message'] =  'Error deleting';
                    $this->httpStatusCode = 400;
                }
            return null;

        }

        $this->apiResponse['message'] =  'You are not allowed to delete this team';
        $this->httpStatusCode = 400;
    }

    /**
     * Edit method
     *
     * @return Response|null
     */
    public function edit($team_id)
    {        
        $this->request->allowMethod('put');

        $name = $this->Validator->__getRequestKey('name');

        $player_id = $this->Validator->__getRequestKey('player_id');
         // Validating if name team is being sended
        if($this->Validator->is_emptyID($name , [ 'status_code' => 400, 'message' => "name is required" ]))
            return null;

         // Validating if team_id team is being sended
        if($this->Validator->is_emptyID($team_id , [ 'status_code' => 400, 'message' => "id is required" ]))
            return null;

         // Validating if player_id is being sended
        if($this->Validator->is_emptyID($player_id, [ 'status_code' => 400, 'message' => "player_id is required" ]))
            return null;
        
        $team_info = $this->Team->normalize($this->request->getData());
     
        $team = $this->Teams->patchEntity($this->Teams->newEntity(), $team_info);

        $team->id = $team_id;

         // Validating if player is owner the team 
        if($this->TeamPlayers->getIsOwner($player_id, $team_id)){
            if($this->Validator->was_saved($this->Teams->save($team))) {
                $this->apiResponse['teams'] =  $this->Teams->__get($team->id);
                return null;
            }
             
        }

        $this->apiResponse['message'] =  'You are not allowed to edit this team';
        $this->httpStatusCode = 400;
              
    }



    /**
     * Edit method
     *
     * @return Response|null
     */
    public function teams()
    {        
        $this->request->allowMethod('get');

        $options = array(
            'fields' => array('id', 'name','logo'),
            'order' => array('name' => 'DESC'),
            'limit' => 5
        );
 
        $this->paginate = $options;

        pr($this->paginate($this->Teams->find("all")));

        $this->apiResponse['teams'] =  $this->paginate($this->Teams->find("all"));


    }



}
