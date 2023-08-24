<?php

namespace Mayanksdudakiya\StateMachine\Tests\Feature;

use Illuminate\Support\Facades\Config;
use Mayanksdudakiya\StateMachine\Tests\Fixtures\FakeModel;
use Mayanksdudakiya\StateMachine\Tests\TestCase;
use Illuminate\Support\Str;
use Mayanksdudakiya\StateMachine\Exceptions\GraphNotFoundException;
use Mayanksdudakiya\StateMachine\State;
use Mayanksdudakiya\StateMachine\Transitions;

class StateMachineTest extends TestCase
{
    /** @test */
    public function initial_state_can_be_stored_while_creating_model()
    {
        $fakeModel = FakeModel::create([
            'uuid' => Str::uuid(),
            'delivery_fee' => 5,
            'amount' => 100,
        ]);

        $this->assertEquals('open', $fakeModel->order_status);
    }

    /** @test */
    public function valid_graph_can_be_set_with_empty_instance()
    {
        $fakeModel = new FakeModel();
        $this->assertEquals(null, $fakeModel->setGraph('exampleGraph'));
    }

    /** @test */
    public function invalid_graph_name_should_throw_exception()
    {
        $this->expectException(GraphNotFoundException::class);

        $fakeModel = new FakeModel();
        $fakeModel->setGraph('InvalidGraphName');
    }

    /** @test */
    public function get_current_state_method_should_return_current_state()
    {
        $fakeModel = new FakeModel();
        $fakeModel->setGraph('exampleGraph');

        $expectedState = new State('open', [
            'title' => 'open',
            'uuid' => '6ea65f69-e45d-409e-b740-9a18e7060cbd',
            'initial' => true,
        ]);

        $this->assertEquals($expectedState, $fakeModel->getCurrentState());
    }

    /** @test */
    public function get_next_transition_method_should_return_next_state()
    {
        $fakeModel = new FakeModel();
        $fakeModel->setGraph('exampleGraph');

        $expectedNextTransition['open_to_pending_payment'] = new Transitions(
            'open_to_pending_payment',
            'open',
            'pending_payment',
            null,
            [
                "from" => "open",
                "to" => [
                    "pending_payment",
                ]
            ]
        );

        $this->assertEquals($expectedNextTransition, $fakeModel->getNextTransitions());
    }

    /** @test */
    public function process_next_transition_and_get_current_state()
    {
        $fakeModel = FakeModel::create([
            'uuid' => Str::uuid(),
            'delivery_fee' => 5,
            'amount' => 100,
        ]);

        $fakeModel->setGraph('exampleGraph');

        $nextTransition = $fakeModel->getNextTransitions();

        $currentState = $fakeModel->process(key($nextTransition))->getCurrentState();

        $expectedState = new State('pending_payment', [
            'title' => 'pending_payment',
            'uuid' => '727abfdd-b726-4dac-a14e-241d9616dc4a',
        ]);

        $this->assertEquals($currentState, $expectedState);
    }
}
