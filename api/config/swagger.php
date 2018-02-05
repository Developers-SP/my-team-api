<?php
use Cake\Core\Configure;

return [
    'Swagger' => [
        'ui' => [
            'title' => 'MyTeamCSGO API Docs',
            'validator' => false,
            'api_selector' => false,
            'route' => '/documentation',
            'schemes' => ['http', 'https']
        ],
        'docs' => [
            'crawl' => Configure::read('debug'),
            'route' => 'documentation/',
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
