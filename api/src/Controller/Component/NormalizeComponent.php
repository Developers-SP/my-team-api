<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Http\Client;
use Cake\Core\Configure;

class NormalizeComponent extends Component
{
    protected $_defaultConfig = [];
    
	public function player($player) {

		$first_name = $last_name = null;
		if(!empty($player['realname'])) {
			$name_info = $this->split_name($player['realname']);

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

    private function split_name($name) {
	    $name = trim($name);
	    $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
	    $first_name = trim( preg_replace('#'.$last_name.'#', '', $name ) );
	    
	    return [
	    	'first_name' => $first_name, 
	    	'last_name'  => $last_name
	    ];
	}
}