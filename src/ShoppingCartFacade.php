<?php

namespace Flowframe\ShoppingCart;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Flowframe\ShoppingCart\ShoppingCart
 */
class ShoppingCartFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'shopping-cart';
    }
}
