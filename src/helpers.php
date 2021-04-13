<?php

use Flowframe\ShoppingCart\ShoppingCart;

if (! function_exists('cart')) {
    function cart(): ShoppingCart
    {
        return app()->get(ShoppingCart::class);
    }
}
