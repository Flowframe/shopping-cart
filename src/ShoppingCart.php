<?php

namespace Flowframe\ShoppingCart;

use Flowframe\ShoppingCart\Managers\CouponManager;
use Flowframe\ShoppingCart\Managers\FeeManager;
use Flowframe\ShoppingCart\Managers\ItemManager;
use Flowframe\ShoppingCart\Models\Fee;

class ShoppingCart
{
    public function items(): ItemManager
    {
        return new ItemManager;
    }

    public function fees(): FeeManager
    {
        return new FeeManager;
    }

    public function coupons(): CouponManager
    {
        return new CouponManager;
    }

    public function subtotal(bool $withVat = true): float
    {
        return $this->items()->total(
            withVat: $withVat,
            withCoupons: false,
        );
    }

    public function empty(): void
    {
        session()->forget('shopping_cart');
    }

    public function total(
        bool $withVat = true,
        bool $withFees = true,
        bool $withCoupons = true,
    ): float {
        $total = $this
            ->items()
            ->total($withVat, $withCoupons);

        if ($withFees) {
            $fees = $this->fees()
                ->get()
                ->map(fn (Fee $fee) => $fee->total($withVat))
                ->sum();

            $total += $fees;
        }

        return $total;
    }

    public function vat(
        bool $withFees = true,
        bool $withCoupons = true,
    ): float {
        $totalWithVat = $this->total(
            withFees: $withFees,
            withCoupons: $withCoupons,
        );

        $totalWithoutVat = $this->total(
            withVat: false,
            withFees: $withFees,
            withCoupons: $withCoupons,
        );

        return $totalWithVat - $totalWithoutVat;
    }
}
