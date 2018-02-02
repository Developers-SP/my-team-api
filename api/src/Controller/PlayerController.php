<?php
 
namespace App\Controller;
 
use RestApi\Controller\ApiController;
use RestApi\Utility\JwtToken;
 
/*                
			      */
class PlayerController extends ApiController
{
 	
 	public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Steam');
        $this->loadComponent('API');

    }
    
    public function login()
	{
	    $this->request->allowMethod('post');
	    
	    // Validating if player_id is being sended
	    if(empty($this->request->getData()['id'])) {
			$this->httpStatusCode = 400;
			$this->apiResponse['message'] = "id is required";

			return null;
	    }
	    $player_id = $this->request->getData()['id'];
	    
	    // Getting player data if exists
	    $player = $this->Player->__get($player_id);

	    // Validating if player exists
	    if(!empty($player)) {
	    	$this->apiResponse['player'] = $player;
    		$this->apiResponse['new'] 	 = 0;

    		return null;
	    }

	    // Getting player data in Steam
		$player_info = $this->Steam->getUserInfo($player_id);

		// Validating if player_id exists
		if(empty($player_info)) {
			$this->httpStatusCode = 404;
			$this->apiResponse['message'] = "Player not found";

			return null;
		}

		// Merge steam data with Player table
		$player = $this->Player->patchEntity($this->Player->newEntity(), $player_info);

		// Saving Player
		if ($this->Player->save($player)) {
			$player = $this->Player->__get($player_id);

			$this->apiResponse['player'] = $player;
			$this->apiResponse['new'] 	 = 1;
		}else {
			$this->httpStatusCode = 500;
			$this->apiResponse['message'] = "Unexpected Error";
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
	    if(empty($player_id)) {
			$this->httpStatusCode = 400;
			$this->apiResponse['message'] = "id is required";

			return null;
	    }

	    // Getting player on database
	    try {
	    	$player = $this->Player->get($player_id);	
	    } catch (\Exception $e) {
	    	$this->httpStatusCode = 404;
			$this->apiResponse['message'] = "Player not found";

			return null;
	    }

	    // Merge Request Data with Player Table
		$player = $this->Player->patchEntity($player, $this->request->
			getData());

		// Saving Player
		if (!$this->Player->save($player)) {
			
			$this->httpStatusCode = 500;
			$this->apiResponse['message'] = "Unexpected Error";
		}

		return null;
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
	    if(empty($player_id)) {
			$this->httpStatusCode = 400;
			$this->apiResponse['message'] = "id is required";

			return null;
	    }

	    // Getting player data in Steam
		$player_info = $this->Steam->getUserInfo($player_id);
		
		// Validating if player_id exists
		if(empty($player_info)) {
			$this->httpStatusCode = 404;
			$this->apiResponse['message'] = "Player not found";

			return null;
		}

	    // Getting player on database
	    $player = $this->Player->get($player_id);

	    // Merge Request Data with Player Table
		$player = $this->Player->patchEntity($player, $player_info);

		// Saving Player
		if (!$this->Player->save($player)) {
			
			$this->httpStatusCode = 500;
			$this->apiResponse['message'] = "Unexpected Error";
		}

	}

	public function stats($player_id = null)
	{
		$this->request->allowMethod('get');

		// Validating if player_id is being sended
	    if(empty($player_id)) {
			$this->httpStatusCode = 400;
			$this->apiResponse['message'] = "id is required";

			return null;
	    }

	    // Getting stats from Steam
	    $stats = $this->Steam->getUserStats($player_id);

	    if(empty($stats)) {
			$this->httpStatusCode = 404;
			$this->apiResponse['message'] = "Stats are not available for this id";

			return null;
	    }

	    $this->apiResponse['stats'] = $stats;
	}
}
