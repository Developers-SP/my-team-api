<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Http\Client;
use Cake\Core\Configure;

class SteamComponent extends Component
{
    protected $_defaultConfig = [];

    public function startup()
    {
        $this->http = new Client();
        $this->key = Configure::read('Steam.key');

    }
    
    // método responsável pela criação da senha.
    public function getUserInfo($steam_id)
    {
        if(!empty($steam_id)) {
            $url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key={$this->key}&steamids={$steam_id}";

            $response = $this->http->get($url);
            
            if(!empty($response->json['response']['players'][0]))
                return $this->__normalize($response->json['response']['players'][0]);
            
        }

        return [];
    }

    private function __normalize($player) {
        
        return [
            'steam_id'      => $player['steamid'],
            'steam_name'    => $player['personaname'],
            'avatar'        => $player['avatarfull'],
        ];
    }
}