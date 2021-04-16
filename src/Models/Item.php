<?php

namespace Flowframe\ShoppingCart\Models;

use Flowframe\ShoppingCart\Enums\CouponType;
use Flowframe\ShoppingCart\Facades\ShoppingCart;

class Item extends AbstractItem implements Contracts\Taxable
{
    public function __construct(
        public string | int $id,
        public string $name,
        public float $price,
        public float $vat,
        public int $quantity = 1,
        public array $options = [],
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

    public function priceWithVat(): float
    {
        return $this->price * $this->vatDecimal();
    }

    public function vatDecimal(): float
    {
        return ($this->vat / 100) + 1;
    }

    public function vat(): float
    {
        return $this->subtotalWithVat() - $this->subtotalWithoutVat();
    }

    public function subtotalWithVat(): float
    {
        return $this->subtotalWithoutVat() * $this->vatDecimal();
    }

    public function subtotalWithoutVat(): float
    {
        return $this->price * $this->quantity;
    }

    public function total(bool $withVat = true, bool $withCoupons = true): float
    {
        $totalWithoutVat = $this->subtotalWithoutVat();

        if ($withCoupons) {
            /** @var Coupon $coupon */
            foreach (ShoppingCart::coupons()->get()->toArray() as $coupon) {
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
}
