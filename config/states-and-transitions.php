<?php

return [
    'graph' => 'exampleGraph', // Name of the current graph - there can be many of them attached to the same object
    'property_path' => 'exampleModelLogic',  // Property path of the object actually holding the state
    'states' => [
        ['title' => 'state_0', 'uuid' => '6ea65f69-e45d-409e-b740-9a18e7060cbd', 'initial' => true],
        ['title' => 'state_1', 'uuid' => '727abfdd-b726-4dac-a14e-241d9616dc4a'],
        ['title' => 'state_2', 'uuid' => '7793ff1a-dac1-4a2e-aef6-e6d3a71c412b'],
        ['title' => 'state_3', 'uuid' => 'b7cf9e3c-e90b-4112-9e86-4bb3248805e8'],
        ['title' => 'state_4', 'uuid' => '3137f934-b397-4c37-9e21-361187197b31'],
    ],
    'transitions' => [
        'state_0' => [
            0 => [
                'from' => 'state_0',
                'to' => ['state_1'],
            ]
        ],
        'state_1' => [
            0 => [
                'from' => 'state_1',
                'to' => ['state_0','state_1', 'state_2'],
            ]
        ],
        'state_2' => [
            0 => [
                'from' => 'state_2',
                'to' => ['state_1', 'state_2', 'state_3'],
            ]
        ],
        'state_3' => [
            0 => [
                'from' => 'state_3',
                'to' => ['state_2', 'state_3', 'state_4'],
            ]
        ],
        'state_4' => [
            0 => [
                'from' => 'state_4',
                'to' => ['state_3', 'state_4'],
            ]
        ],
    ]
];
