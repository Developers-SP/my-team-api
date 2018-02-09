<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Http\Client;
use Cake\Core\Configure;

class APIComponent extends Component
{
    protected $_defaultConfig = [];
    
    private $api_resource;
    private $delimeter = ";";

    public function initialize(array $config)
    {
    	parent::initialize($config);
    	$this->api_resource = $this->config('api_resource');
    }

    public function order_by() {
    	
    	if(!empty($this->api_resource->request->getQuery('order'))) {
    		$order_by = [];
    		
    		$orders = explode($this->delimeter, $this->api_resource->request->getQuery('order'));
    		$types = explode($this->delimeter, $this->api_resource->request->getQuery('type'));

    		foreach ($orders as $key => $order) {
    			$order_by[$order] 	= (empty($types[$key]) ? "DESC" : $types[$key]);
    		}

    		return $order_by;
    	}

    	return [];
    }
    
}