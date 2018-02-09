<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Http\Client;
use Cake\Core\Configure;

class ValidatorComponent extends Component
{
    protected $_defaultConfig = [];
    private $api_resource;
    private $responses = [
    	'is_emptyID' 	=> [ 'status_code' => 400, 'message' => "id is required" ], 
    	'is_steamValid'	=> [ 'status_code' => 404, 'message' => "Player not found" ],
    	'was_saved' 	=> [ 'status_code' => 500, 'message' =>"Unexpected Error" ]
    ];

    public function initialize(array $config)
    {
    	parent::initialize($config);
    	$this->api_resource = $this->config('api_resource');
    }

    public function __getRequestKey($key = null) {
        
        if(!empty($this->api_resource->request->getData()[$key]))
            return $this->api_resource->request->getData()[$key];
        

        return null;
    }

	public function is_emptyID($steam_id = null, $response = null) {
		if(empty($steam_id)) {
			$this->setReturn(__FUNCTION__, $response);

			return true;
		}

		return false;
    }

    public function is_steamValid($steam_player = null, $response = null) {
    	if(empty($steam_player)) {
    		$this->setReturn(__FUNCTION__, $response);

			return false;
    	}

    	return true;
    }

    public function was_saved($saved, $message = null) {
    	if(!$saved) {
    		$this->setReturn(__FUNCTION__, $message);

    		return false;
    	}

    	return true;
    }
    
    private function setReturn($function, $response = null) {
    	$response = $this->getResponseParameters($function, $response);

    	$this->api_resource->httpStatusCode 			= $response['status_code'];
    	$this->api_resource->apiResponse['message'] 	= $response['message'];
    }

    private function getResponseParameters($function, $response = null) {
    	$parameters['status_code'] 	= (empty($response['status_code']) 	? $this->responses[$function]['status_code'] 	: $response['status_code']);
    	$parameters['message'] 		= (empty($response['message']) 		? $this->responses[$function]['message'] 		: $response['message']);
    	
    	return $parameters;
    }
}