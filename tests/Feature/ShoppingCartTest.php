<?php

namespace Flowframe\ShoppingCart\Tests\Features;

use Flowframe\ShoppingCart\Facades\ShoppingCart;
use Flowframe\ShoppingCart\Tests\TestCase;

class ShoppingCartTest extends TestCase
{
    /** @test */
    public function it_can_perform_a_simple_checkout_flow(): void
    {
        ShoppingCart::items()->add([
            'id' => 1,
            'name' => 'Shoes',
            'price' => 100,
            'vat' => 10,
        ]);

        ShoppingCart::items()->add([
            'id' => 2,
            'name' => 'Jeans',
            'price' => 50,
            'vat' => 10,
        ]);

        $this->assertEquals(165, ShoppingCart::total(withVat: true));

        $this->assertEquals(150, ShoppingCart::total(withVat: false));

        ShoppingCart::coupons()->add([
            'id' => '50%-off',
            'name' => '50% off',
            'value' => 50,
            'type' => 'percentage',
        ]);

        ShoppingCart::coupons()->add([
            'id' => 'first-time-discount',
            'name' => '$10 off',
            'value' => 10,
            'type' => 'fixed',
        ]);

        ShoppingCart::fees()->add([
            'id' => 'shipping',
            'name' => 'Global shipping',
            'price' => 50,
            'vat' => 10,
        ]);

        $this->assertEquals(2, ShoppingCart::items()->count());

        // without vat ((100 * 0.5 - 10)) + ((50 * 0.5 - 10)) + (50) = 105
        $this->assertEquals(105, ShoppingCart::total(withVat: false));

        // with vat ((100 * 0.5 - 10) * 1.1) + ((50 * 0.5 - 10) * 1.1) + (50 * 1.1) = 115.5
        $this->assertEquals(115.5, ShoppingCart::total(withVat: true));

        ShoppingCart::coupons()->remove('50%-off');

        ShoppingCart::coupons()->remove('first-time-discount');

        // without vat 100 + 50 + 50 = 200
        $this->assertEquals(200, ShoppingCart::total(withVat: false));

        // with vat (100 * 1.1) + (50 * 1.1) + (50 * 1.1) = 220
        $this->assertEquals(220, ShoppingCart::total(withVat: true));
    }
}
