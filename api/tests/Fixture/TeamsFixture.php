<?php 
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class TeamsFixture extends TestFixture
{
      // Optional. Set this property to load fixtures to a different test datasource
      public $connection = 'test';

      public $fields = [
          'id' => ['type' => 'integer', 'length' => 11, 'null' => false],
          'name' => ['type' => 'string', 'length' => 255, 'null' => false],
          'description'      => ['type' => 'text', 'null' => true],
          'tag' => ['type' => 'string', 'length' => 255, 'null' => true],
          'logo' => ['type' => 'string', 'length' => 255, 'null' => true],
          'created'   => 'datetime',
          'modified'  => ['type' => 'datetime', 'null' => true],
          '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']]
          ]
      ];

      public $records = [
          [
              'name' => 'VK',
              'description' => 'test',
              'tag' => 'Dib',
              'logo'  => 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/5d/5d82427acccb75bc31f945f65dec3dafd50cc0af_full.jpg',
              'created' => '2018-01-18 10:39:23',
              'modified' => '2018-03-18 10:41:31'
          ],
          [
              'name' => 'VK 2',
              'description' => '',
              'tag' => '',
              'created' => '2018-01-18 10:41:23',
              'modified' => '2018-01-18 10:43:31'
          ],
          [
              'name' => 'VK 3',
              'description' => '',
              'tag' => '',
              'created' => '2018-01-18 11:41:23',
              'modified' => '2018-01-18 11:43:31'
          ]
      ];
 }