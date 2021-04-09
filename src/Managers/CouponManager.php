<?php

namespace Flowframe\ShoppingCart\Managers;

use Flowframe\ShoppingCart\Models\AbstractItem;
use Flowframe\ShoppingCart\Models\Coupon;

class CouponManager extends AbstractManager
{
    protected function itemClass(): string
    {
        return Coupon::class;
    }

    public function add(AbstractItem | array $coupon): self
    {
        $coupon = is_array($coupon)
            ? Coupon::fromArray($coupon)
            : $coupon;

        $this->updateSession($this->all()->add($coupon));

        return $this;
    }
}
