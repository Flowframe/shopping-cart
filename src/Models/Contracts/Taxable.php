<?php

namespace Flowframe\ShoppingCart\Models\Contracts;

interface Taxable
{
    public function vat(): float;
}
