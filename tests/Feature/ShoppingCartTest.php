<?php

namespace Flowframe\ShoppingCart\Tests\Features;

use Flowframe\ShoppingCart\Tests\TestCase;

class ShoppingCartTest extends TestCase
{
    /** @test */
    public function it_can_perform_a_simple_checkout_flow(): void
    {
        cart()->addItem([
            'id' => 1,
            'name' => 'Shoes',
            'price' => 100,
            'vat' => 10,
        ]);

        cart()->addItem([
            'id' => 2,
            'name' => 'Jeans',
            'price' => 50,
            'vat' => 10,
        ]);

        $this->assertEquals(165, cart()->total(withVat: true));

        $this->assertEquals(150, cart()->total(withVat: false));

        cart()->addCoupon([
            'id' => '50%-off',
            'name' => '50% off',
            'value' => 50,
            'type' => 'percentage',
        ]);

        cart()->addCoupon([
            'id' => 'first-time-discount',
            'name' => '$10 off',
            'value' => 10,
            'type' => 'fixed',
        ]);

        cart()->addFee([
            'id' => 'shipping',
            'name' => 'Global shipping',
            'price' => 50,
            'vat' => 10,
        ]);

        $this->assertEquals(2, cart()->items()->count());

        // without vat ((100 * 0.5 - 10)) + ((50 * 0.5 - 10)) + (50) = 105
        $this->assertEquals(105, cart()->total(withVat: false));

        // with vat ((100 * 0.5 - 10) * 1.1) + ((50 * 0.5 - 10) * 1.1) + (50 * 1.1) = 115.5
        $this->assertEquals(115.5, cart()->total(withVat: true));

        cart()->removeCoupon('50%-off');

        cart()->removeCoupon('first-time-discount');

        // without vat 100 + 50 + 50 = 200
        $this->assertEquals(200, cart()->total(withVat: false));

        // with vat (100 * 1.1) + (50 * 1.1) + (50 * 1.1) = 220
        $this->assertEquals(220, cart()->total(withVat: true));
    }
}
