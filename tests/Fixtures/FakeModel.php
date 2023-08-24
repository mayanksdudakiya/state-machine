<?php

namespace Mayanksdudakiya\StateMachine\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Mayanksdudakiya\StateMachine\StateMachine;
use Mayanksdudakiya\StateMachine\Tests\Fixtures\States\OrderState;

class FakeModel extends Model
{
    use StateMachine;

    protected $guarded = [];

    protected $casts = [
        'order_status' => OrderState::class,
    ];
}
