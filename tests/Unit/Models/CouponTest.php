<?php

use Flowframe\ShoppingCart\Enums\CouponType;
use Flowframe\ShoppingCart\Exceptions\ValueDecimalMethodNotCallable;
use Flowframe\ShoppingCart\Models\Coupon;

it('can calculate the value decimal', function () {
    $coupon = new Coupon(
        id: 'test-coupon',
        name: '50% Discount',
        type: CouponType::PERCENTAGE,
        value: 50,
    );

    expect($coupon->valueDecimal())->toBe(0.5);
});

it('throws an exception if valueDecimal is called when the type is not `CouponType::PERCENTAGE`', function () {
    $coupon = new Coupon(
        id: 'test-coupon',
        name: '50% Discount',
        type: CouponType::FIXED,
        value: 50,
    );

    $coupon->valueDecimal();
})->throws(ValueDecimalMethodNotCallable::class);
