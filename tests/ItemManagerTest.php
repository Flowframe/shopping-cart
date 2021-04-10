<?php

namespace Flowframe\ShoppingCart\Tests;

use Flowframe\ShoppingCart\Models\Item;
use Flowframe\ShoppingCart\ShoppingCart;

class ItemManagerTest extends TestCase
{
    /** @test */
    public function it_can_add_one_item()
    {
        $item = new Item(
            id: 'laravel-hambino-baseball-cap',
            name: 'LARAVEL "HAMBINO" BASEBALL CAP',
            price: 24.99,
            vat: 21,
        );

        ShoppingCart::items()->add($item);

        $this->assertEquals(
            $item,
            ShoppingCart::items()
                ->get()
                ->first()
        );

        $this->assertEquals(
            $item->quantity,
            ShoppingCart::items()
                ->get()
                ->first()
                ->quantity
        );
    }

    /** @test */
    public function it_can_add_items_and_auto_increment()
    {
        $item = new Item(
            id: 'laravel-hambino-baseball-cap',
            name: 'LARAVEL "HAMBINO" BASEBALL CAP',
            price: 24.99,
            vat: 21,
        );

        ShoppingCart::items()
            ->add($item)
            ->add($item);

        $this->assertEquals(
            2,
            ShoppingCart::items()->count()
        );

        $this->assertEquals(
            2,
            ShoppingCart::items()
                ->get()
                ->first()
                ->quantity
        );
    }

    /** @test */
    public function it_can_add_different_items()
    {
        $itemOne = new Item(
            id: 'laravel-hambino-baseball-cap',
            name: 'LARAVEL "HAMBINO" BASEBALL CAP',
            price: 24.99,
            vat: 21,
        );

        $itemTwo = new Item(
            id: 'laravel-royal-sticker-pack',
            name: 'LARAVEL "ROYAL" STICKER PACK',
            price: 14.99,
            vat: 21,
        );

        ShoppingCart::items()
            ->add($itemOne)
            ->add($itemTwo);

        $this->assertEquals(
            2,
            ShoppingCart::items()->count()
        );

        $this->assertEquals(
            $itemOne->quantity,
            ShoppingCart::items()
                ->get()
                ->first()
                ->quantity
        );
    }

    /** @test */
    public function it_can_find_items()
    {
        $item = new Item(
            id: 'laravel-hambino-baseball-cap',
            name: 'LARAVEL "HAMBINO" BASEBALL CAP',
            price: 24.99,
            vat: 21,
        );

        ShoppingCart::items()->add($item);

        $this->assertEquals(
            $item,
            ShoppingCart::items()
                ->get()
                ->first()
        );

        $this->assertEquals(
            $item->name,
            ShoppingCart::items()->find('laravel-hambino-baseball-cap')->name
        );
    }

    /** @test */
    public function it_can_decrement_items()
    {
        $item = new Item(
            id: 'laravel-hambino-baseball-cap',
            name: 'LARAVEL "HAMBINO" BASEBALL CAP',
            price: 24.99,
            vat: 21,
            quantity: 2,
        );

        ShoppingCart::items()->add($item);

        $this->assertEquals(
            2,
            ShoppingCart::items()
                ->get()
                ->first()
                ->quantity
        );

        ShoppingCart::items()->decrement(id: $item->id);

        $this->assertEquals(
            1,
            ShoppingCart::items()
                ->get()
                ->first()
                ->quantity
        );

        ShoppingCart::items()->decrement(id: $item->id);

        $this->assertEquals(
            0,
            ShoppingCart::items()->count()
        );
    }
}
