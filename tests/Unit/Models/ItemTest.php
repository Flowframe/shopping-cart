<?php

namespace Flowframe\ShoppingCart\Tests\Unit\Models;

use Flowframe\ShoppingCart\Enums\CouponType;
use Flowframe\ShoppingCart\Models\Coupon;
use Flowframe\ShoppingCart\Models\Item;
use Flowframe\ShoppingCart\Tests\TestCase;

class ItemTest extends TestCase
{
    public Item $item;

    public function setUp(): void
    {
        parent::setUp();

        $this->item = new Item(
            id: 'laravel-hambino-baseball-cap',
            name: 'LARAVEL "HAMBINO" BASEBALL CAP',
            price: 24.99,
            vat: 21,
            quantity: 2,
        );
    }

    /** @test */
    public function it_can_increment(): void
    {
        $this->item->incrementQuantity();

        $this->assertEquals(3, $this->item->quantity);
    }

    /** @test */
    public function it_can_decrement(): void
    {
        $this->item->decrementQuantity();

        $this->assertEquals(1, $this->item->quantity);
    }

    /** @test */
    public function it_can_be_created_from_array(): void
    {
        $itemFromArray = new Item(...[
            'id' => 'laravel-hambino-baseball-cap',
            'name' => 'LARAVEL "HAMBINO" BASEBALL CAP',
            'price' => 24.99,
            'vat' => 21,
            'quantity' => 2,
        ]);

        $this->assertEquals($this->item, $itemFromArray);
    }

    /** @test */
    public function it_can_calculate_vat_percentage_as_decimal(): void
    {
        $this->assertEquals(1.21, $this->item->vatDecimal());
    }

    /** @test */
    public function it_can_calculate_price_without_vat(): void
    {
        // 24.99 * 2 = 49.98
        $this->assertEquals(49.98, $this->item->totalWithoutVat());
    }

    /** @test */
    public function it_can_calculate_price_with_vat(): void
    {
        // 24.99 * 2 * 1.21 = 60.4758
        $this->assertEquals(60.4758, $this->item->totalWithVat());
    }

    /** @test */
    public function it_can_apply_a_coupon(): void
    {
        $coupon = new Coupon(
            id: 'test-coupon',
            name: 'Test coupon',
            value: 50,
            type: CouponType::PERCENTAGE,
        );

        $this->item->applyCoupon($coupon);

        $this->assertEquals($coupon, $this->item->coupons[$coupon->id]);
    }

    /** @test */
    public function can_calculate_the_total_with_vat_and_coupons(): void
    {
        // 24.99 * 2 = 49.98
        $this->assertEquals(49.98, $this->item->total(withVat: false, withCoupons: false));

        // 24.99 * 2 * 1.21 = 60.4758
        $this->assertEquals(60.4758, $this->item->total(withVat: true, withCoupons: false));

        $percentageCoupon = new Coupon(
            id: 'percentage-coupon',
            name: 'Percentage coupon',
            value: 50,
            type: CouponType::PERCENTAGE,
        );

        $this->item->applyCoupon($percentageCoupon);

        // 24.99 * 2 * 0.5 = 24.99
        $this->assertEquals(24.99, $this->item->total(withVat: false, withCoupons: true));

        // (24.99 * 2 * 0.5) * 1.21 = 30.2379
        $this->assertEquals(30.2379, $this->item->total(withVat: true, withCoupons: true));

        $fixedCoupon = new Coupon(
            id: 'fixed-coupon',
            name: 'Fixed coupon',
            value: 10,
            type: CouponType::FIXED,
        );

        $this->item->applyCoupon($fixedCoupon);

        // (24.99 * 2 * 0.5) - 10 = 14.99
        $this->assertEquals(14.99, $this->item->total(withVat: false, withCoupons: true));

        // ((24.99 * 2 * 0.5) - 10) * 1.21 = 18.1379
        $this->assertEquals(18.1379, $this->item->total(withVat: true, withCoupons: true));
    }
}
