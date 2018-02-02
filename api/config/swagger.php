<?php
use Cake\Core\Configure;

return [
    'Swagger' => [
        'ui' => [
            'title' => 'MyTeamCSGO API Docs',
            'validator' => true,
            'api_selector' => true,
            'route' => '/docs',
            'schemes' => ['http', 'https']
        ],
        'docs' => [
            'crawl' => Configure::read('debug'),
            'route' => 'docs/',
            'cors' => [
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'GET, POST',
                'Access-Control-Allow-Headers' => 'X-Requested-With'
            ]
        ],
        'library' => [
            'api' => [
                'include' => [
                    ROOT . DS . 'src' . DS . 'Docs'
                ]
                
            ]
        ]
    ]
];

