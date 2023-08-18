<?php

namespace Mayanksdudakiya\StateMachineForOrders;

interface StateMachineForOrdersInterface
{
    public function setGraph(array $config): null;

    public function getGraph(): string;

    public function getCurrentState(): array;

    public function getNextTransitions(): array;

    public function process(string $transitions): array;
}
