<?php

namespace Flowframe\ShoppingCart;

use Flowframe\ShoppingCart\Enums\CouponType;
use Flowframe\ShoppingCart\Managers\CouponManager;
use Flowframe\ShoppingCart\Managers\FeeManager;
use Flowframe\ShoppingCart\Managers\ItemManager;
use Flowframe\ShoppingCart\Models\Fee;
use Flowframe\ShoppingCart\Models\Item;
use Illuminate\Support\Str;

class ShoppingCart
{
    public static function items(): ItemManager
    {
        return new ItemManager;
    }

    public static function fees(): FeeManager
    {
        return new FeeManager;
    }

    public static function coupons(): CouponManager
    {
        return new CouponManager;
    }

    public static function subtotal(bool $withVat = true): float
    {
        return static::items()
            ->all()
            ->map(fn (Item $item) => $item->total($withVat))
            ->sum();
    }

    public static function total(
        bool $withVat = true,
        bool $withFees = true,
        bool $withCoupons = true,
    ): float {
        $total = static::subtotal($withVat);

        $fees = static::fees()
            ->all()
            ->map(fn (Fee $fee) => $fee->total($withVat))
            ->sum();

        if ($withCoupons) {
            $coupons = static::coupons()
                ->all()
                ->toArray();

            foreach ($coupons as $coupon) {
                $total = match ($coupon->type) {
                    CouponType::PERCENTAGE => $total * $coupon->valuePercentage(),
                    CouponType::FIXED => $total - $coupon->value,
                    default => $total
                };
            }
        }

        if ($withFees) {
            $total += $fees;
        }

        return $total;
    }

    /**
     * Allows for magic like `cart()->incrementItem(id: 1, byAmount: 2)`
     */
    public function __call($name, $arguments)
    {
        $sections = Str::of($name)
            ->kebab()
            ->explode('-');

        $action = $sections[0];

        $manager = Str::plural($sections[1]);

        $className = get_class($this);

        call_user_func("{$className}::{$manager}")->{$action}(...$arguments);
    }
}
