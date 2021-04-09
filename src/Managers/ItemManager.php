<?php

namespace Flowframe\ShoppingCart\Managers;

use Flowframe\ShoppingCart\Models\AbstractItem;
use Flowframe\ShoppingCart\Models\Item;

class ItemManager extends AbstractManager
{
    protected function itemClass(): string
    {
        return Item::class;
    }

    public function add(AbstractItem | array $item): self
    {
        /** @var Item $item */
        $item = is_array($item)
            ? Item::fromArray($item)
            : $item;

        $existingItem = $this->find($item->id);

        $existingItem
            ? $this->increment($item->id)
            : $this->updateSession($this->all()->add($item));

        return $this;
    }

    public function increment(int | string $id, int $byAmount = 1): void
    {
        /** @var Item $item */
        $item = $this->find($id);

        if (is_null($item)) {
            return;
        }

        $this->update($item->incrementQuantity($byAmount));
    }

    public function decrement(int | string $id, int $byAmount = 1): void
    {
        /** @var Item $item */
        $item = $this->find($id);

        if (is_null($item)) {
            return;
        }

        if ($item->quantity - $byAmount <= 0) {
            $this->remove($item->id);

            return;
        }

        $this->update($item->decrementQuantity($byAmount));
    }

    public function count(): int
    {
        return $this
            ->all()
            ->sum('quantity');
    }
}
