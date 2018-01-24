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

	    $steam_id = $this->request->getData()['steam_id'];
	    
	    if(!empty($steam_id)) {
	    	$player = $this->Player->__get($steam_id);

	    	if(empty($player)) {
	    		$player_info = $this->Steam->getUserInfo($steam_id);
	    		if(!empty($player_info)) {
	    			$player = $this->Player->newEntity();
	    			$player = $this->Player->patchEntity($player, $player_info);

	    			if ($this->Player->save($player)) {
	    				$player = $this->Player->__get($steam_id);

	    				$this->apiResponse['player'] = $player;
	    				$this->apiResponse['new'] 	 = 1;
	    			}else {
	    				$this->httpStatusCode = 500;
						$this->apiResponse['message'] = "Unexpected Error";
	    			}
	    			
	    		}else {
					$this->httpStatusCode = 400;
					$this->apiResponse['message'] = "Invalid steam_id";
	    		}
	    	}else {
	    		$this->apiResponse['player'] = $player;
	    		$this->apiResponse['new'] 	 = 0;
	    	}
	    }else {
			$this->httpStatusCode = 400;
			$this->apiResponse['message'] = "steam_id is required";
	    }

	}
}
