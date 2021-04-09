<?php

namespace Flowframe\ShoppingCart\Managers;

use Flowframe\ShoppingCart\Models\AbstractItem;
use Flowframe\ShoppingCart\Models\Fee;

class FeeManager extends AbstractManager
{
    protected function itemClass(): string
    {
        return Fee::class;
    }

    public function add(AbstractItem | array $fee): self
    {
        $fee = is_array($fee)
            ? Fee::fromArray($fee)
            : $fee;

        $this->updateSession($this->all()->add($fee));

        return $this;
    }
}
