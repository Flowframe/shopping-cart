<?php

namespace Flowframe\ShoppingCart\Tests\Unit\Models;

use Flowframe\ShoppingCart\Models\Fee;
use Flowframe\ShoppingCart\Tests\TestCase;

class FeeTest extends TestCase
{
    public Fee $fee;

    public function setUp(): void
    {
        parent::setUp();

        $this->fee = new Fee(
            id: 'shipping',
            name: 'Shipping',
            price: 5.00,
            vat: 21,
        );
    }

    /** @test */
    public function it_can_calculate_vat_decimal(): void
    {
        $this->assertEquals(1.21, $this->fee->vatDecimal());
    }

    /** @test */
    public function it_can_calculate_vat(): void
    {
        $this->assertEquals(1.05, $this->fee->vat());
    }

    /** @test */
    public function it_can_calculate_total_with_vat(): void
    {
        $this->assertEquals(6.05, $this->fee->totalWithVat());
    }

    /** @test */
    public function it_can_calculate_total_without_vat(): void
    {
        $this->assertEquals(5.00, $this->fee->totalWithoutVat());
    }

    /** @test */
    public function it_can_calculate_total(): void
    {
        $this->assertEquals(6.05, $this->fee->total(withVat: true));

        $this->assertEquals(5.00, $this->fee->total(withVat: false));
    }
}
