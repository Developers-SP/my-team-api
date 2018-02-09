<?php
 
namespace App\Controller;
 
use RestApi\Controller\ApiController;
use RestApi\Utility\JwtToken;
 
/*                
			      */
class PlayersController extends ApiController
{
 	
 	public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Steam');
        $this->loadComponent('API',[
        	'api_resource' => $this
        ]);
        $this->loadComponent('Normalize');
        $this->loadComponent('Validator',[
        	'api_resource' => $this
        ]);
    }

    public function index() {

    	$this->request->allowMethod('get');

    	$query = $this->Players->find('all')->contain(['teams']);

    	$order = $this->API->order_by();
    	if(!empty($order))
    		$query = $query->order($order);
    	
    	$this->httpStatusCode = 200;
    	$this->apiResponse['players'] = $query->toArray();
    }

    public function login()
	{
	    $this->request->allowMethod('post');
	    
	    $player_id = $this->Validator->__getRequestKey('id');
	    // Validating if player_id is being sended
	    if($this->Validator->is_emptyID($player_id))
	    	return null;
	    
	    
	    // Getting player data if exists
	    $player = $this->Players->__get($player_id);

	    // Validating if player exists
	    if(!empty($player)) {
	    	$this->apiResponse['player'] = $player;
    		$this->apiResponse['new'] 	 = 0;

    		return null;
	    }

	    $player_info = $this->Steam->getUserInfo($player_id);

		// Validating if player_id exists
		if(!$this->Validator->is_steamValid($player_info))
			return null;

	    // Getting player data in Steam
		$player_info = $this->Normalize->player($player_info);


		// Merge steam data with Player table
		$player = $this->Players->patchEntity($this->Players->newEntity(), $player_info);

		// Saving Player

		if($this->Validator->was_saved($this->Players->save($player))) {

			$player = $this->Players->__get($player_id);

			$this->apiResponse['player'] = $player;
			$this->apiResponse['new'] 	 = 1;
		}
				
    	return null;
	    
	}

	/**
     * bar method
     *
     * @return Response|null
     */
	public function edit($player_id = null)
	{
		$this->request->allowMethod('put');

		// Validating if player_id is being sended
	    if($this->Validator->is_emptyID($player_id))
	    	return null;
		
	    // Getting player on database
	    try {
	    	$player = $this->Players->get($player_id);	
	    } catch (\Exception $e) {
	    	$this->httpStatusCode = 404;
			$this->apiResponse['message'] = "Player not found";

			return null;
	    }

	    // Merge Request Data with Player Table
		$player = $this->Players->patchEntity($player, $this->request->
			getData());

		$this->Validator->was_saved($this->Players->save($player));
	}

	/**
     * bar method
     *
     * @return Response|null
     */
	public function updateBySteam($player_id = null)
	{
		$this->request->allowMethod('put');

		// Validating if player_id is being sended
	    if($this->Validator->is_emptyID($player_id))
	    	return null;

	    $player_info = $this->Steam->getUserInfo($player_id);

		// Validating if player_id exists
		if(!$this->Validator->is_steamValid($player_info))
			return null;

	    // Getting player data in Steam
		$player_info = $this->Normalize->player($player_info);

	    // Getting player on database
	    $player = $this->Players->get($player_id);

	    // Merge Request Data with Player Table
		$player = $this->Players->patchEntity($player, $player_info);

		$this->Validator->was_saved($this->Players->save($player));
	}

	public function stats($player_id = null)
	{
		$this->request->allowMethod('get');

		// Validating if player_id is being sended
	    if($this->Validator->is_emptyID($player_id))
	    	return null;

	    // Getting stats from Steam
	    $stats = $this->Steam->getUserStats($player_id);

	    // Validating if player_id exists
		if(!$this->Validator->is_steamValid($stats, ['message' => "Stats are not available for this id"]))
			return null;

	    $this->apiResponse['stats'] = $stats;
	}
}
