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

### Swagger Currency Converter Demo




1. This package provides a `StateMachine` trait, this trait can be used in any model class

```php
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

final class OrderState extends State
{
    public function config(): string
    {
        return 'order-state-and-transition';
        // if config file inside folder then
        // return 'order/order-state-and-transition.php';
    }
}
```

```php
<?php
namespace App\StateMachine\PaymentState;

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
class Payment extends Model
{
    // …

    protected $casts = [
        'order_status' => OrderState::class,
        'payment_status' => PaymentState::class,
    ];
}
```
