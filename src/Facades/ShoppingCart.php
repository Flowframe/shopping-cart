<?php

namespace Flowframe\ShoppingCart\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Flowframe\ShoppingCart\ShoppingCart
 */
class ShoppingCart extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Flowframe\ShoppingCart\ShoppingCart::class;
    }
}
