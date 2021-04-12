<?php

namespace Flowframe\ShoppingCart\Models;

use Flowframe\ShoppingCart\Enums\CouponType;

class Item extends AbstractItem implements Contracts\Taxable
{
    public function __construct(
        public string | int $id,
        public string $name,
        public float $price,
        public float $vat,
        public int $quantity = 1,
        public array $options = [],
        public array $coupons = [],
    ) {
    }

    public function incrementQuantity(int $byAmount = 1): self
    {
        $this->quantity += $byAmount;

        return $this;
    }

    public function decrementQuantity(int $byAmount = 1): self
    {
        $this->quantity -= $byAmount;

        return $this;
    }

    public function vatDecimal(): float
    {
        return ($this->vat / 100) + 1;
    }

    public function vat(): float
    {
        return $this->totalWithVat() - $this->totalWithoutVat();
    }

    public function totalWithVat(): float
    {
        return $this->totalWithoutVat() * $this->vatDecimal();
    }

    public function totalWithoutVat(): float
    {
        return $this->price * $this->quantity;
    }

    public function total(bool $withVat = true, bool $withCoupons = true): float
    {
        $totalWithoutVat = $this->totalWithoutVat();

        if ($withCoupons) {
            /** @var Coupon $coupon */
            foreach ($this->coupons as $coupon) {
                $totalWithoutVat = match ($coupon->type) {
                    CouponType::PERCENTAGE => $totalWithoutVat * $coupon->valueDecimal(),
                    CouponType::FIXED => $totalWithoutVat - $coupon->value,
                    default => $totalWithoutVat
                };
            }
        }

        return $withVat
            ? $totalWithoutVat * $this->vatDecimal()
            : $totalWithoutVat;
    }

    public function applyCoupon(Coupon $coupon): self
    {
        if (array_key_exists($coupon->id, $this->coupons)) {
            return $this;
        }


        $this->coupons[$coupon->id] = $coupon;

        return $this;
    }
}
