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
        $this->baseUrl = "http://api.steampowered.com/";
        $this->appId = 730;
    }
    
    public function getUserInfo($player_id = null)
    {
        if(!empty($player_id)) {
            $url = "{$this->baseUrl}ISteamUser/GetPlayerSummaries/v0002";

            $response = $this->http->get($url, [
                'key' => $this->key,
                'steamids' => $player_id
            ]);
            
            if(!empty($response->json['response']['players'][0]))
                return $response->json['response']['players'][0];
            
        }

        return [];
    }

    public function getUserStats($player_id = null)
    {
        if(!empty($player_id)) {
            $url = "{$this->baseUrl}ISteamUserStats/GetUserStatsForGame/v0002";

            $response = $this->http->get($url, [
                'key' => $this->key,
                'steamid' => $player_id,
                'appid' => $this->appId
            ]);

            if(empty($response->json['playerstats']['stats']))
                return [];

            $stats = $response->json['playerstats']['stats'];

            return $stats;
        }

        return [];
    }

}