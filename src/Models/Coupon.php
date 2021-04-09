<?php

namespace Flowframe\ShoppingCart\Models;

class Coupon extends AbstractItem
{
    public function __construct(
        public string | int $id,
        public string $name,
        public string $type,
        public float $value,
        public array $options = [],
    ) {
    }

    public static function fromArray(array $item = []): self
    {
        return new static(
            id: $item['id'],
            name: $item['name'],
            type: $item['type'],
            value: $item['value'],
            options: $item['options'],
        );
    }

    public function valuePercentage(): float
    {
        return (100 - $this->value) / 100;
    }
}
