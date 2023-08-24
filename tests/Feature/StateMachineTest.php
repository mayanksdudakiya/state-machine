<?php

namespace Mayanksdudakiya\StateMachine\Tests\Feature;

use Illuminate\Support\Facades\Config;
use Mayanksdudakiya\StateMachine\Tests\Fixtures\FakeModel;
use Mayanksdudakiya\StateMachine\Tests\TestCase;
use Illuminate\Support\Str;

class StateMachineTest extends TestCase
{
    /** @test */
    public function initial_state_can_be_stored_while_creating()
    {
        $fakeModel = FakeModel::create([
            'uuid' => Str::uuid(),
            'delivery_fee' => 5,
            'amount' => 100,
        ]);

        $this->assertEquals('open', $fakeModel->order_status);
    }
}
