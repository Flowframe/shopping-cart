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
        /** @var Coupon $coupon */
        $coupon = is_array($coupon)
            ? new Coupon(...$coupon)
            : $coupon;

        if ($this->has($coupon->id)) {
            return $this;
        }

        $this->updateSession($this->get()->add($coupon));

        return $this;
    }
}
