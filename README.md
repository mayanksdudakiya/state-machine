# State Machine For Order Laravel Package

## Installation

By default this package will be installed in pet-shop-api project
Clone this repo into `packages` folder in: https://github.com/mayanksdudakiya/pet-shop-api

Add below line in composer.json if not exists and run the `composer require mayanksdudakiya/state-machine:dev-main`

```bash
"require": {
    "mayanksdudakiya/state-machine": "dev-main",
},
"repositories": [
        {
            "type": "path",
            "url": "packages/mayanksdudakiya/state-machine",
            "options": {
                "symlink": true
            }
        }
    ]
```


### Testing

```bash
composer test
```

### Swagger Doc

```bash
{{baseUrl}}/api/documentation#/
```

### How To Use State Machine Order Package?

1. This package provides a `StateMachine` trait, this trait can be used in any model class

```php

use Mayanksdudakiya\StateMachine\StateMachine;

class Order extends Model
{
    use StateMachine;

    // Other methods
}
```

2. You can assign multiple states column to the same model for same trait

Single state

```php
Schema::table('orders', function (Blueprint $table) {
    $table->string('order_status');
});
```

Multiple states
```php
Schema::table('orders', function (Blueprint $table) {
    $table->string('order_status');
    $table->string('payment_status');
});
```

3. All these state columns must be castes with State class provided by the package for that you need to create State class
for each corresponding database column.

```php
<?php
namespace App\StateMachine\OrderState;

use Mayanksdudakiya\StateMachine\State;

final class OrderState extends State
{
    public function config(): string
    {
        return 'order-state-and-transition';
        // if config file inside folder then
        // return 'folder.order-state-and-transition';
    }
}
```

```php
<?php
namespace App\StateMachine\PaymentState;

use Mayanksdudakiya\StateMachine\State;

final class PaymentState extends State
{
    public function config(): string
    {
        return 'payment-state-and-transition';
    }
}
```


4. Now, casts the States as below

```php
<?php
namespace App\Models;

use App\StateMachine\OrderState;
use App\StateMachine\PaymentState;

class Order extends Model
{
    // …

    protected $casts = [
        'order_status' => OrderState::class,
        'payment_status' => PaymentState::class,
    ];
}
```


### Trait workflow

```php
php artisan tinker

// Create a new instance of the Model
>>> $model = new \App\Models\Model();
=> App\Models\Model {#3661}

// Define your graph
>>> $model->setGraph($graph));
=> null

// Get current state
>>> dump($model->getCurrentState());
App\StateMachine\State^ {#3665
  -name: "state_0"
  -metadata: array:3 [
    "title" => "state_0"
    "uuid" => "6ea65f69-e45d-409e-b740-9a18e7060cbd"
    "initial" => true
  ]
}

// Get next transitions
>>> dump($model->getNextTransitions());
array:1 [
  "state_0_to_state_1" => App\StateMachine\Transition^ {#3675
    -name: "state_0_to_state_1"
    -initialStateName: "state_0"
    -resultingStateName: "state_1"
    -acceptConditionCallable: null
    -metadata: array:2 [
      "from" => "state_0"
      "to" => array:1 [
        0 => "state_1"
      ]
    ]
  }
]

// Progress to next transition and get the current state
>>> dump($model->process('state_0_to_state_1')->getCurrentState());
App\StateMachine\State^ {#3677
  -name: "state_1"
  -metadata: array:2 [
    "title" => "state_1"
    "uuid" => "727abfdd-b726-4dac-a14e-241d9616dc4a"
  ]
}

// Get the new available transitions
>>> dump($model->getNextTransitions());
array:2 [
  "state_1_to_state_1" => App\StateMachine\Transition^ {#3674
    -name: "state_1_to_state_1"
    -initialStateName: "state_1"
    -resultingStateName: "state_1"
    -acceptConditionCallable: null
    -metadata: array:2 [
      "from" => "state_1"
      "to" => array:2 [
        0 => "state_1"
        1 => "state_2"
      ]
    ]
  }
  "state_1_to_state_2" => App\StateMachine\Transition^ {#3672
    -name: "state_1_to_state_2"
    -initialStateName: "state_1"
    -resultingStateName: "state_2"
    -acceptConditionCallable: null
    -metadata: array:2 [
      "from" => "state_1"
      "to" => array:2 [
        0 => "state_1"
        1 => "state_2"
      ]
    ]
  }
]
```