<?php

namespace Flowframe\ShoppingCart\Tests\Unit;

use Flowframe\ShoppingCart\ShoppingCart;
use Flowframe\ShoppingCart\Tests\TestCase;

class HelpersTest extends TestCase
{
    /** @test */
    public function it_can_resolve_the_facade(): void
    {
        $this->assertInstanceOf(ShoppingCart::class, cart());
    }

    /** @test */
    public function it_can_call_methods(): void
    {
        cart()->items()->add([
            'id' => 'laravel-hambino-baseball-cap',
            'name' => 'LARAVEL "HAMBINO" BASEBALL CAP',
            'price' => 24.99,
            'vat' => 21,
            'quantity' => 2,
        ]);

        $this->assertEquals(2, cart()->items()->count());

        cart()->empty();

        $this->assertEquals(0, cart()->items()->count());
    }
}
