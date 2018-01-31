<?php
 
namespace App\Controller;
 
use RestApi\Controller\ApiController;
use RestApi\Utility\JwtToken;
 
/**
 * Foo Controller
 *
 */
class PlayerController extends ApiController
{
 	
 	public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Steam');
        $this->loadComponent('API');
    }
    
    /**
     * bar method
     *
     * @return Response|null
     */
    public function login()
	{
	    $this->request->allowMethod('post');

	    // Getting steam_id parameter
	    $steam_id = $this->request->getData()['steam_id'];
	    
	    // Validating if steam_id is being sended
	    if(empty($steam_id)) {
			$this->httpStatusCode = 400;
			$this->apiResponse['message'] = "steam_id is required";

			return null;
	    }
	    
	    // Getting player data if exists
	    $player = $this->Player->__get($steam_id);

	    // Validating if player exists
	    if(!empty($player)) {
	    	$this->apiResponse['player'] = $player;
    		$this->apiResponse['new'] 	 = 0;

    		return null;
	    }

	    // Getting player data in Steam
		$player_info = $this->Steam->getUserInfo($steam_id);

		// Validating if steam_id exists
		if(empty($player_info)) {
			$this->httpStatusCode = 400;
			$this->apiResponse['message'] = "Invalid steam_id";

			return null;
		}

		// Merge steam data with Player table
		$player = $this->Player->patchEntity($this->Player->newEntity(), $player_info);

		// Saving Player
		if ($this->Player->save($player)) {
			$player = $this->Player->__get($steam_id);

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
	public function edit($steam_id = null)
	{
		$this->request->allowMethod('put');

		// Validating if steam_id is being sended
	    if(empty($steam_id)) {
			$this->httpStatusCode = 400;
			$this->apiResponse['message'] = "steam_id is required";

			return null;
	    }

	    // Getting player on database
	    $player = $this->Player->get($steam_id);

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
	public function updateBySteam($steam_id)
	{
		$this->request->allowMethod('post');

		// Validating if steam_id is being sended
	    if(empty($steam_id)) {
			$this->httpStatusCode = 400;
			$this->apiResponse['message'] = "steam_id is required";

			return null;
	    }

	    // Getting player data in Steam
		$player_info = $this->Steam->getUserInfo($steam_id);
		
		// Validating if steam_id exists
		if(empty($player_info)) {
			$this->httpStatusCode = 400;
			$this->apiResponse['message'] = "Invalid steam_id";

			return null;
		}

	    // Getting player on database
	    $player = $this->Player->get($steam_id);

	    // Merge Request Data with Player Table
		$player = $this->Player->patchEntity($player, $player_info);

		// Saving Player
		if (!$this->Player->save($player)) {
			
			$this->httpStatusCode = 500;
			$this->apiResponse['message'] = "Unexpected Error";
		}

	}
}
