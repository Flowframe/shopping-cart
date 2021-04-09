<?php

namespace Flowframe\ShoppingCart\Models;

class Fee extends AbstractItem implements Contracts\Taxable
{
    public function __construct(
        public string | int $id,
        public string $name,
        public float $price,
        public float $vat,
        public array $options = [],
    ) {
    }

    public static function fromArray(array $item): self
    {
        return new static(
            id: $item['id'],
            name: $item['name'],
            price: $item['price'],
            vat: $item['vat'],
            options: $item['options'],
        );
    }

    public function vat(): float
    {
        return $this->price * ($this->vat / 100);
    }

    public function total($withVat = true): float
    {
        return $withVat
            ? $this->price
            : $this->price - $this->vat();
    }
}
