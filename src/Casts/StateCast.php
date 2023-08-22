<?php

namespace Mayanksdudakiya\StateMachine\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class StateCast implements CastsAttributes
{
    public function get($model, string $key, mixed $value, array $attributes): string
    {
        return (string) $value;
    }

    public function set($model, string $key, mixed $value, array $attributes): string
    {
        return (string) $value;
    }
}