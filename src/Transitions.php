<?php

namespace Mayanksdudakiya\StateMachine;

use Illuminate\Database\Eloquent\Model;

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

    public static function handle(Model $model, string $field, string $value): Model
    {
        $model->{$field} = $value;
        $model->save();

        return $model;
    }
}
