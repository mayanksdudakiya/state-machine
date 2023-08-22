<?php

namespace Mayanksdudakiya\StateMachine;

use Illuminate\Support\Facades\Config;
use Mayanksdudakiya\StateMachine\Exceptions\GraphNotFoundException;
use Mayanksdudakiya\StateMachine\Exceptions\InvalidPropertyException;
use Mayanksdudakiya\StateMachine\Exceptions\TransitionsException;

trait StateMachine
{
    public function __construct(
        private array $traitStateConfig = [],
        private array $traitStateFields = [],
        private array $nextTransitions = [],
        private string $traitStateCurrentField = '',
        private string $traitGraphName = '',
    ) {
    }

    private function getConfigs(): array
    {
        $casts = $this->getCasts();

        $states = [];

        foreach ($casts as $field => $state) {
            if (! is_subclass_of($state, State::class)) {
                continue;
            }

            $states[] = Config::get($state::config());
            $this->traitStateFields[] = $field;
        }

        return $states;
    }

    public function setGraph(string $graphName): null
    {
        $configs = $this->getConfigs();

        $this->traitGraphName = $graphName;

        $allGraphColumns = array_column($configs, 'graph');

        throw_unless($allGraphColumns, new GraphNotFoundException('No matching graph found. Please provide valid `graph` key name in configurations.'));

        $configKey = array_search($graphName, $allGraphColumns);

        $this->setCurrentConfigAndField($configs, $configKey);

        return null;
    }

    private function setCurrentConfigAndField(array $configs, int $configKey): void
    {
        $this->traitStateConfig = $configs[$configKey];
        $this->traitStateCurrentField = $this->traitStateFields[$configKey];
    }

    public function getCurrentState(): State
    {
        throw_unless($this->traitStateConfig, new GraphNotFoundException("No matching graph found. Please set graph using `setGraph('graphName')` key name in configurations."));

        $field = $this->{$this->traitStateCurrentField};

        if (empty($this->{$this->traitStateCurrentField})) {
            return $this->getInitialState();
        }

        $currentState = $this->findStateByKeyValue('title', $field);

        return new State(
            $currentState['title'],
            $currentState
        );
    }

    private function getInitialState(): State
    {
        $initialStateColumns = array_column($this->traitStateConfig['states'], 'initial');

        throw_if(count($initialStateColumns) > 1, new InvalidPropertyException("Multiple `initial` states found in `{$this->traitGraphName}` graph."));

        throw_if(count($initialStateColumns) <= 0, new InvalidPropertyException("No `initial` states found in `{$this->traitGraphName}` graph, please set initial state using `'initial' => true`"));

        $initialState = $this->findStateByKeyValue('initial', true);

        return new State(
            $initialState['title'],
            $initialState
        );
    }

    private function findStateByKeyValue($key, $value): array
    {
        return current(
            array_filter(
                $this->traitStateConfig['states'],
                fn ($state) => isset($state[$key]) && $state[$key] === $value
            )
        );
    }

    private function findTransitionsByKeyValue($key): array
    {
        return current($this->traitStateConfig['transitions'][$key]);
    }

    public function getNextTransitions(): array
    {
        $currentState = $this->getCurrentState()->name;
        $getTransitions = $this->findTransitionsByKeyValue($currentState);

        $from = $this->cleanTransitionKey($getTransitions['from']);

        foreach($getTransitions['to'] as $toTransition) {
            $to = $this->cleanTransitionKey($toTransition);
            $transitionKey = "{$from}_to_{$to}";

            $this->nextTransitions[$transitionKey] = new Transitions(
                $transitionKey,
                $from,
                $to,
                null,
                $getTransitions,
            );

            $from = $to;
        }

        return $this->nextTransitions;
    }

    private function cleanTransitionKey(string $key): string
    {
        return str_replace(' ', '_', $key);
    }

    public function process(string $transitionTo)
    {
        throw_unless(isset($this->nextTransitions[$transitionTo]), new TransitionsException("Transition not found for `{$transitionTo}`"));

        $resultingState = $this->nextTransitions[$transitionTo]->resultingStateName;
        Transitions::handle($this, $this->traitStateCurrentField, $resultingState);

        return $this;
    }
}
