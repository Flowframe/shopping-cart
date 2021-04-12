<?php

namespace Flowframe\ShoppingCart\Models;

use Flowframe\ShoppingCart\Enums\CouponType;
use Flowframe\ShoppingCart\Exceptions\ValueDecimalMethodNotCallable;

class Coupon extends AbstractItem
{
    public function __construct(
        public string | int $id,
        public string $name,
        public string $type,
        public float $value,
        public array $options = [],
    ) {
    }

    public function valueDecimal(): float
    {
        if ($this->type === CouponType::FIXED) {
            throw ValueDecimalMethodNotCallable::becauseTypeShouldBePercentage();
        }

        return (100 - $this->value) / 100;
    }
}
