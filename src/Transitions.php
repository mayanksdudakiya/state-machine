<?php

namespace Mayanksdudakiya\StateMachine;

class Transitions
{
    public function __construct(
        public string $name = '',
        public string $initialStateName = '',
        public string $resultingStateName = '',
        public ?string $acceptConditionCallable = '',
        public array $metadata = [],
    ) {
    }
}
