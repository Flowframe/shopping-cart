<?php

namespace Flowframe\ShoppingCart\Exceptions;

use Exception;

class ValueDecimalMethodNotCallable extends Exception
{
    public static function becauseTypeShouldBePercentage(): static
    {
        return new static('Method `valueDecimal()` is not callable because the type coupon type is not `CouponType::PERCENTAGE`.');
    }
}
