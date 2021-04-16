<?php

namespace Flowframe\ShoppingCart\Tests\Unit\Models;

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
    public function it_can_calculate_subtotal_without_vat(): void
    {
        // 24.99 * 2 = 49.98
        $this->assertEquals(49.98, $this->item->subtotalWithoutVat());
    }

    /** @test */
    public function it_can_calculate_subtotal_with_vat(): void
    {
        // 24.99 * 2 * 1.21 = 60.4758
        $this->assertEquals(60.4758, $this->item->subtotalWithVat());
    }

    /** @test */
    public function it_can_calculate_price_with_vat(): void
    {
        // 24.99 * 1.21 = 30.2379
        $this->assertEquals(30.2379, $this->item->priceWithVat());
    }
}
