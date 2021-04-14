<?php

namespace Flowframe\ShoppingCart\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Flowframe\ShoppingCart\Managers\ItemManager items()
 * @method static \Flowframe\ShoppingCart\Managers\FeeManager fees()
 * @method static \Flowframe\ShoppingCart\Managers\CouponManager coupons()
 * @method static float subtotal(bool $withVat = true)
 * @method static void empty()
 * @method static float total(bool $withVat = true, bool $withFees = true, bool $withCoupons = true)
 * 
 * @see \Flowframe\ShoppingCart\ShoppingCart
 */
class ShoppingCart extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Flowframe\ShoppingCart\ShoppingCart::class;
    }
}
