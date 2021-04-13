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
        return $this->subtotalWithVat() - $this->subtotalWithoutVat();
    }

    public function subtotalWithVat(): float
    {
        return $this->subtotalWithoutVat() * $this->vatDecimal();
    }

    public function subtotalWithoutVat(): float
    {
        return $this->price;
    }

    public function total(bool $withVat = true): float
    {
        return $withVat
            ? $this->subtotalWithVat()
            : $this->subtotalWithoutVat();
    }
}
