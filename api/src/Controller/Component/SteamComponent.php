<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Http\Client;
use Cake\Core\Configure;

class SteamComponent extends Component
{
    protected $_defaultConfig = [];
    public $components = ['Crowley', "Normalize"];
    private $crowley = null;

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

    public function getSteamIdNickname($url_name = null)
    {
        if(!empty($url_name)) {
            $url = "{$this->baseUrl}ISteamUser/ResolveVanityURL/v0001/";
            
            $response = $this->http->get($url, [
                'key' => $this->key,
                'vanityurl' => $url_name
            ]);

            if(!empty($response->json['response']['steamid']))
                return $response->json['response']['steamid'];
        }

        return null;
    }

    public function getPlayers($steam_name = null, $page = 1) {
        if(!empty($steam_name)) {
            $link_cookie = "http://steamcommunity.com/search/users/";   
            $response = $this->http->get($link_cookie);
            
            $session_id = $response->getCookie('sessionid');

            if(empty($session_id))
                return null;

            $link = "http://steamcommunity.com/search/SearchCommunityAjax";

            $response = $this->http->get($link, [
                'text' => $steam_name,
                'filter' => 'users',
                'sessionid' => $session_id,
                'steamid_user' => false,
                'page'         => $page
            ],[
                'headers' => [
                    'Cookie' => 'sessionid={$session_id};'
                ]
            ]);

            if(empty($response->json['success']) or $response->json['success'] == 0)
                return null;
           
            
            $html_crowler = $response->json['html'];

            $this->Crowley->__setup($html_crowler);

            $players_list = $this->Crowley->getGenericAttribute("div.search_row", $this->Crowley->xpath, '', false);

            $players = [];
            foreach ($players_list as $key => $player) {
                $player_dom = new \DOMDocument();
                $player_dom->appendChild($player_dom->importNode($player, true));

                $player_xpath = new \DOMXPath($player_dom);


                $basic_data = $this->Crowley->getGenericAttribute('a.searchPersonaName', $player_xpath, '', false);
                
                $avatar = $this->Crowley->getGenericAttribute('div.avatarMedium > a > img', $player_xpath, '', false);

                $steam_name = $basic_data[0]->nodeValue;
                $avatar     = $avatar[0]->getAttribute('src');
                $url        = $basic_data[0]->getAttribute('href');
                $steam_id   = $this->Normalize->SteamIdByUrl($url);
                
                $players[] = [
                    'steam_id'   => $steam_id,
                    'steam_name' => $steam_name,
                    'avatar'     => $avatar,
                    'url'        => $url
                ];

            }

            return $players;
        }

        return null;
    }

}