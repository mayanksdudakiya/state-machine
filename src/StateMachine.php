<?php

namespace Mayanksdudakiya\StateMachine;

use Illuminate\Database\Eloquent\Model;
use Mayanksdudakiya\StateMachine\Exceptions\InvalidPropertyException;

trait StateMachine
{
    public function __construct(private array $config = [])
    {
        $this->config = config('states-and-transitions');

        $this->setDefaultState();
        $this->doesModelHasStateProperty();
    }

    private function setDefaultState(): void
    {
        if (!isset($this->config['property_path'])) {
            $this->config['property_path'] = 'state';
        }
    }

    private function doesModelHasStateProperty(): void
    {
        $modelProperty = $this->config['property_path'];
        $className = class_basename($this);

        if (!property_exists($this, $modelProperty)) {
            throw new InvalidPropertyException("The class `{$className}` does not have the expected property `{$modelProperty}`.");
        }
    }

    public function setGraph(string $graphName): null
    {
        if (!isset($this->config[$graphName])) {

        }
        return null;
    }

    public function getGraph(): string
    {
        return '';
    }

    public function getCurrentState(): array
    {
        return [];
    }

    public function getNextTransitions(): array
    {
        return [];
    }

    public function process(string $transitions): array
    {
        return [];
    }
}