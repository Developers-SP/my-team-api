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

        return [
            'id'            => $player['steamid'],
            'steam_name'    => $player['personaname'],
            'avatar'        => $player['avatarfull'],
        ];
    }
}