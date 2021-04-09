<?php

namespace Flowframe\ShoppingCart\Models;

class Item extends AbstractItem implements Contracts\Taxable
{
    public function __construct(
        public string | int $id,
        public string $name,
        public float $price,
        public float $vat,
        public int $quantity = 1,
        public array $options = [],
    ) {
    }

    public static function fromArray(array $item = []): self
    {
        return new static(
            id: $item['id'],
            name: $item['name'],
            price: $item['price'],
            vat: $item['vat'],
            quantity: $item['quantity'],
            options: $item['options'],
        );
    }

    public function incrementQuantity(int $byAmount = 1): self
    {
        $this->quantity += $byAmount;

        return $this;
    }

    public function decrementQuantity(int $byAmount = 1): self
    {
        $this->quantity -= $byAmount;

        return $this;
    }

    public function vat(): float
    {
        return ($this->price * $this->quantity) * ($this->vat / 100);
    }

    public function total($withVat = true): float
    {
        $priceWithVat = $this->price * $this->quantity;
        $priceWithoutVat = $priceWithVat - $this->vat();

        return $withVat
            ? $priceWithVat
            : $priceWithoutVat;
    }
}
