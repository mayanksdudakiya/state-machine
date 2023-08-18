<?php

namespace Mayanksdudakiya\StateMachine;

use Illuminate\Database\Eloquent\Model;
use Mayanksdudakiya\StateMachine\Exceptions\InvalidPropertyException;

trait StateMachine
{
    public function __construct(private array $config = [])
    {
        $this->initializeConfig();
        $this->setDefaultState();
        $this->validateModelProperty();
    }

    private function initializeConfig(): void
    {
        $this->config = config('states-and-transitions');
    }

    private function setDefaultState(): void
    {
        $this->config['property_path'] ??= 'state';
    }

    private function validateModelProperty(): void
    {
        $modelProperty = $this->config['property_path'];
        $className = class_basename($this);

        if (!property_exists($this, $modelProperty) && !method_exists($this, $modelProperty)) {
            throw new InvalidPropertyException("The class `{$className}` does not have the expected property or relationship method `{$modelProperty}`.");
        }
    }

    public function setGraph(string $graphName): null
    {
        $className = class_basename($this);

        if (!empty($this->config['graph']) && $this->config['graph'] !== $graphName) {
            throw new InvalidPropertyException("The graph name `{$graphName}` does not exists in the config for the class `{$className}`.");
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
