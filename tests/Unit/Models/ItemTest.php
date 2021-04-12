<?php

use Flowframe\ShoppingCart\Enums\CouponType;
use Flowframe\ShoppingCart\Models\Coupon;
use Flowframe\ShoppingCart\Models\Item;

beforeEach(function () {
    $this->item = new Item(
        id: 'laravel-hambino-baseball-cap',
        name: 'LARAVEL "HAMBINO" BASEBALL CAP',
        price: 24.99,
        vat: 21,
        quantity: 2,
    );
});

it('can increment', function () {
    $this->item->incrementQuantity();

    expect($this->item->quantity)->toBe(3);
});

it('can decrement', function () {
    $this->item->decrementQuantity();

    expect($this->item->quantity)->toBe(1);
});

it('can be created from array', function () {
    $itemFromArray = new Item(...[
        'id' => 'laravel-hambino-baseball-cap',
        'name' => 'LARAVEL "HAMBINO" BASEBALL CAP',
        'price' => 24.99,
        'vat' => 21,
        'quantity' => 2,
    ]);

    expect($this->item)->toEqual($itemFromArray);
});

it('can calculate the vat percentage as decimal', function () {
    expect($this->item->vatDecimal())->toBe(1.21);
});

it('can calculate the price without vat', function () {
    // 24.99 * 2 = 49.98
    expect($this->item->totalWithoutVat())->toBe(49.98);
});

it('can calculate the price with vat', function () {
    // 24.99 * 2 * 1.21 = 60.4758
    expect($this->item->totalWithVat())->toBe(60.4758);
});

it('can apply a coupon', function () {
    $coupon = new Coupon(
        id: 'test-coupon',
        name: 'Test coupon',
        value: 50,
        type: CouponType::PERCENTAGE,
    );

    $this->item->applyCoupon($coupon);

    expect($this->item->coupons)->toHaveCount(1);

    expect($this->item->coupons[0])->toBe($coupon);
});

it('can calculate the total with vat and coupons', function () {
    // 24.99 * 2 = 49.98
    expect($this->item->total(withVat: false, withCoupons: false))->toBe(49.98);

    // 24.99 * 2 * 1.21 = 60.4758
    expect($this->item->total(withVat: true, withCoupons: false))->toBe(60.4758);

    $percentageCoupon = new Coupon(
        id: 'percentage-coupon',
        name: 'Percentage coupon',
        value: 50,
        type: CouponType::PERCENTAGE,
    );

    $this->item->applyCoupon($percentageCoupon);

    // 24.99 * 2 * 0.5 = 24.99
    expect($this->item->total(withVat: false, withCoupons: true))->toBe(24.99);

    // (24.99 * 2 * 0.5) * 1.21 = 30.2379
    expect($this->item->total(withVat: true, withCoupons: true))->toBe(30.2379);

    $fixedCoupon = new Coupon(
        id: 'fixed-coupon',
        name: 'Fixed coupon',
        value: 10,
        type: CouponType::FIXED,
    );

    $this->item->applyCoupon($fixedCoupon);

    // (24.99 * 2 * 0.5) - 10 = 14.99
    expect($this->item->total(withVat: false, withCoupons: true))->toBe(14.99);

    // ((24.99 * 2 * 0.5) - 10) * 1.21 = 18.1379
    expect($this->item->total(withVat: true, withCoupons: true))->toBe(18.1379);
});
