<?php

namespace Flowframe\ShoppingCart\Tests\Unit\Models;

use Flowframe\ShoppingCart\Enums\CouponType;
use Flowframe\ShoppingCart\Exceptions\ValueDecimalMethodNotCallable;
use Flowframe\ShoppingCart\Models\Coupon;
use Flowframe\ShoppingCart\Tests\TestCase;

class CouponTest extends TestCase
{
    /** @test */
    public function it_can_calculate_the_value_decimal(): void
    {
        $coupon = new Coupon(
            id: 'test-coupon',
            name: '50% Discount',
            type: CouponType::PERCENTAGE,
            value: 50,
        );

        $this->assertEquals(0.5, $coupon->valueDecimal());
    }

    /** @test */
    public function it_throws_an_exception_if_the_type_is_not_percentage(): void
    {
        $coupon = new Coupon(
            id: 'test-coupon',
            name: '50% Discount',
            type: CouponType::FIXED,
            value: 50,
        );

        $this->expectException(ValueDecimalMethodNotCallable::class);

        $coupon->valueDecimal();
    }
}
