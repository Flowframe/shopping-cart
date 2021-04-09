<?php

namespace Flowframe\ShoppingCart\Tests;

use Flowframe\ShoppingCart\Enums\CouponType;
use Flowframe\ShoppingCart\Models\Coupon;
use Flowframe\ShoppingCart\Models\Fee;
use Flowframe\ShoppingCart\Models\Item;
use Flowframe\ShoppingCart\ShoppingCart;

class ShoppingCartTest extends TestCase
{
    /** @test */
    public function it_can_calculate_subtotals()
    {
        $itemOne = new Item(
            id: 1,
            name: 'Hat',
            price: 20,
            vat: 10,
        );

        $itemTwo = new Item(
            id: 2,
            name: 'Shoes',
            price: 100,
            vat: 10,
        );

        ShoppingCart::items()
            ->add($itemOne)
            ->add($itemTwo);

        $this->assertEquals(120, ShoppingCart::subtotal(withVat: true));

        $this->assertEquals(108, ShoppingCart::subtotal(withVat: false));

        ShoppingCart::coupons()->add(new Coupon(
            id: 'BLACK-FRIDAY-2021',
            name: 'Black Friday 2021 50% off',
            type: CouponType::PERCENTAGE,
            value: 50,
        ));

        $this->assertEquals(60, ShoppingCart::total());

        ShoppingCart::coupons()->add(new Coupon(
            id: 'FLWFRM',
            name: 'Get a $10 discount',
            type: CouponType::FIXED,
            value: 10,
        ));

        $this->assertEquals(50, ShoppingCart::total());

        ShoppingCart::fees()->add(new Fee(
            id: 'SHIPPING',
            name: 'Shipping costs',
            price: 5,
            vat: 21,
        ));

        $this->assertEquals(55, ShoppingCart::total());
    }
}
