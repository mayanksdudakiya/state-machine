<?php

namespace Mayanksdudakiya\StateMachineForOrders;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mayanksdudakiya\StateMachineForOrders\Skeleton\SkeletonClass
 */
class StateMachineForOrdersFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'state-machine-for-orders';
    }
}
