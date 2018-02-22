<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Http\Client;
use Cake\Core\Configure;

class NormalizeComponent extends Component
{
    protected $_defaultConfig = [];
    public $components = ['Steam'];
    
	public function player($player) {

		$first_name = $last_name = null;
		if(!empty($player['realname'])) {
			$name_info = $this->splitName($player['realname']);

			$first_name = $name_info['first_name'];
			$last_name = $name_info['last_name'];
		}

        return [
            'id'            => $player['steamid'],
            'steam_name'    => $player['personaname'],
            'first_name'    => $first_name,
            'last_name'    	=> $last_name,
            'avatar'        => $player['avatarfull']
        ];
    }

    public function SteamIdByUrl($url = "") {
		if(!empty($url)) {
			$split = explode("/", $url);

			$steam_id = $split[count($split)-1];

			if(strpos($url, "/id/"))
				$steam_id = $this->Steam->getSteamIdNickname($steam_id);

			return $steam_id;
		}

		return null;
	}

    private function splitName($name) {
	    $name = trim($name);
	    $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
	    $first_name = trim( preg_replace('#'.$last_name.'#', '', $name ) );
	    
	    return [
	    	'first_name' => $first_name, 
	    	'last_name'  => $last_name
	    ];
	}

	
}