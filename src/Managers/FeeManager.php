<?php

namespace Flowframe\ShoppingCart\Managers;

use Flowframe\ShoppingCart\Managers\Contracts\ManagesVat;
use Flowframe\ShoppingCart\Models\AbstractItem;
use Flowframe\ShoppingCart\Models\Fee;

class FeeManager extends AbstractManager implements ManagesVat
{
    protected function itemClass(): string
    {
        return Fee::class;
    }

    public function add(AbstractItem | array $fee): self
    {
        /** @var Fee $fee */
        $fee = is_array($fee)
            ? new Fee(...$fee)
            : $fee;

        if ($this->has($fee->id)) {
            return $this;
        }

        $this->updateSession($this->get()->add($fee));

        return $this;
    }

    public function vat(): float
    {
        return $this
            ->get()
            ->map(fn (Fee $fee) => $fee->vat())
            ->sum();
    }
}
