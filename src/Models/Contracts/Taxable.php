<?php

namespace Flowframe\ShoppingCart\Models\Contracts;

interface Taxable
{
    public function vat(): float;

    public function vatDecimal(): float;

    public function subtotalWithVat(): float;

    public function subtotalWithoutVat(): float;
}
