<?php 
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class PlayersFixture extends TestFixture
{
      // Optional. Set this property to load fixtures to a different test datasource
      public $connection = 'test';

      public $fields = [
          'id' => ['type' => 'string', 'length' => 50, 'null' => false],
          'steam_name' => ['type' => 'string', 'length' => 255, 'null' => false],
          'email'      => ['type' => 'string', 'length' => 255, 'null' => true],
          'first_name' => ['type' => 'string', 'length' => 255, 'null' => true],
          'last_name' => ['type' => 'string', 'length' => 255, 'null' => true],
          'last_name' => ['type' => 'string', 'length' => 255, 'null' => true],
          'active'    => ['type' => 'integer', 'length' => 1],
          'avatar'    => ['type' => 'string', 'length' => 255, 'null' => true],
          'created'   => 'datetime',
          'modified'  => ['type' => 'datetime', 'null' => true],
          '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']]
          ]
      ];

      public $records = [
          [
              'id'  => '76561198121209165',
              'steam_name' => 'Kenobi',
              'first_name' => 'Pedro',
              'last_name' => 'Dib',
              'active' => 1,
              'avatar'  => 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/5d/5d82427acccb75bc31f945f65dec3dafd50cc0af_full.jpg',
              'created' => '2018-01-18 10:39:23',
              'modified' => '2018-03-18 10:41:31'
          ],
          [
              'id'  => '76561198121209165112',
              'steam_name' => 'Kenobi Error',
              'created' => '2018-01-18 10:41:23',
              'modified' => '2018-01-18 10:43:31'
          ],
          [
             'id'  => '765611909165112',
              'steam_name' => 'Kenobi Error 2',
              'created' => '2018-01-18 11:41:23',
              'modified' => '2018-01-18 11:43:31'
          ]
      ];
 }