<?php

namespace Flowframe\ShoppingCart;

use Flowframe\ShoppingCart\Managers\CouponManager;
use Flowframe\ShoppingCart\Managers\FeeManager;
use Flowframe\ShoppingCart\Managers\ItemManager;
use Flowframe\ShoppingCart\Models\Fee;
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
        return static::items()->total(
            withVat: $withVat,
            withCoupons: false,
        );
    }

    public function empty(): void
    {
        session()->forget('shopping_cart');
    }

    public static function total(
        bool $withVat = true,
        bool $withFees = true,
        bool $withCoupons = true,
    ): float {
        $items = static::items()->get();

        if ($withCoupons) {
            $coupons = static::coupons()
                ->get()
                ->toArray();

            foreach ($coupons as $coupon) {
                foreach ($items as $item) {
                    $item->applyCoupon($coupon);
                }
            }
        }

        $total = static::items()->total($withVat, $withCoupons);

        if ($withFees) {
            $fees = static::fees()
                ->get()
                ->map(fn (Fee $fee) => $fee->total($withVat))
                ->sum();

            $total += $fees;
        }

        return $total;
    }

    /**
     * Allows for magic like `cart()->incrementItem(id: 1, byAmount: 2)`
     */
    public function __call(mixed $name, mixed $arguments)
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
