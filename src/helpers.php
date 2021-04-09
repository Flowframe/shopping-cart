<?php

use Flowframe\ShoppingCart\ShoppingCart;

if (! function_exists('cart')) {
    function cart()
    {
        return new ShoppingCart;
    }
}
