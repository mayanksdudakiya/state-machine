<?php

namespace Mayanksdudakiya\StateMachine;

use Illuminate\Contracts\Database\Eloquent\Castable;
use Mayanksdudakiya\StateMachine\Casts\StateCast;

class State implements Castable
{
    public function __construct(
        public string $name = '',
        public array $metadata = [],
    ) {
    }

    public static function castUsing(array $arguments)
    {
        return new StateCast(static::class);
    }
}
