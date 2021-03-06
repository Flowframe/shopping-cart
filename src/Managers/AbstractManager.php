<?php

namespace Flowframe\ShoppingCart\Managers;

use Flowframe\ShoppingCart\Models\AbstractItem;
use Illuminate\Support\Collection;

abstract class AbstractManager
{
    abstract protected function itemClass(): string;

    abstract public function add(AbstractItem | array $item): self;

    public function get(): Collection
    {
        return $this
            ->items()
            ->filter(fn (AbstractItem $item) => get_class($item) === $this->itemClass());
    }

    public function count(): int
    {
        return $this
            ->get()
            ->count();
    }

    public function find(int | string $id): ?AbstractItem
    {
        return $this
            ->get()
            ->firstWhere('id', $id);
    }

    public function has(int | string $id): bool
    {
        return (bool) $this->find($id);
    }

    public function remove(int | string $id): void
    {
        if (! $this->has($id)) {
            return;
        }

        $items = $this
            ->get()
            ->filter(fn (AbstractItem $item) => $item->id !== $id);

        $this->updateSession($items);
    }

    public function update(AbstractItem $updatedItem): void
    {
        $items = $this
            ->get()
            ->map(
                fn (AbstractItem $item) => $item->id === $updatedItem->id
                    ? $updatedItem
                    : $item
            );

        $this->updateSession($items);
    }

    public function empty(): void
    {
        session(['shopping_cart' => $this->allExceptForThis()]);
    }

    protected function items(): Collection
    {
        return collect(session('shopping_cart'));
    }

    protected function allExceptForThis(): Collection
    {
        return $this
            ->items()
            ->filter(fn (AbstractItem $item) => get_class($item) !== $this->itemClass());
    }

    protected function updateSession(Collection $items): void
    {
        session([
            'shopping_cart' => $this
                ->allExceptForThis()
                ->merge($items),
        ]);
    }
}
