<?php

namespace Flowframe\ShoppingCart\Models;

abstract class AbstractItem
{
    public string | int $id;

    public string $name;

    abstract public static function fromArray(array $item): self;
}
