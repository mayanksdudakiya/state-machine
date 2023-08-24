<?php

return [
    'graph' => 'exampleGraph', // Name of the current graph - there can be many of them attached to the same object
    'property_path' => 'order_status',  // Property path of the object actually holding the state
    'states' => [
        ['title' => 'open', 'uuid' => '6ea65f69-e45d-409e-b740-9a18e7060cbd', 'initial' => true],
        ['title' => 'pending_payment', 'uuid' => '727abfdd-b726-4dac-a14e-241d9616dc4a'],
        ['title' => 'paid', 'uuid' => '7793ff1a-dac1-4a2e-aef6-e6d3a71c412b'],
        ['title' => 'shipped', 'uuid' => 'b7cf9e3c-e90b-4112-9e86-4bb3248805e8'],
        ['title' => 'cancelled', 'uuid' => '3137f934-b397-4c37-9e21-361187197b31'],
    ],
    'transitions' => [
        'open' => [
            [
                'from' => 'open',
                'to' => ['pending_payment'],
            ]
        ],
        'pending_payment' => [
            [
                'from' => 'pending_payment',
                'to' => ['open','pending_payment', 'paid'],
            ]
        ],
        'paid' => [
            [
                'from' => 'paid',
                'to' => ['pending_payment', 'paid', 'shipped'],
            ]
        ],
        'shipped' => [
            [
                'from' => 'shipped',
                'to' => ['paid', 'shipped', 'cancelled'],
            ]
        ],
        'cancelled' => [
            [
                'from' => 'cancelled',
                'to' => ['shipped', 'cancelled'],
            ]
        ],
    ]
];
