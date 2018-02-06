<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Http\Client;
use Cake\Core\Configure;

class TeamsComponent extends Component
{
    protected $_defaultConfig = [];

        public function normalize($team) {
            return [
                'name'          => $team['name'],
                'description'   => (!isset($team['description'])) ? '' : $team['description'],
                'tag'           => (!isset($team['tag'])) ? '' : $team['tag'],
                'logo'          => (!isset($team['logo'])) ? '' : $team['logo'],
            ];
        }
}
