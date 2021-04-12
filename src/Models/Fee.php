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

    public function vatDecimal(): float
    {
        return ($this->vat / 100) + 1;
    }

    public function vat(): float
    {
        return $this->totalWithVat() - $this->totalWithoutVat();
    }

    public function totalWithVat(): float
    {
        return $this->totalWithoutVat() * $this->vatDecimal();
    }

    public function totalWithoutVat(): float
    {
        return $this->price;
    }

    public function total(bool $withVat = true): float
    {
        return $withVat
            ? $this->totalWithVat()
            : $this->totalWithoutVat();
    }
}
