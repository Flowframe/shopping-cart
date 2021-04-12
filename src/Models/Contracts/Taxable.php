<?php

namespace Flowframe\ShoppingCart\Models\Contracts;

interface Taxable
{
    public function vat(): float;

    public function vatDecimal(): float;

    public function totalWithVat(): float;

    public function totalWithoutVat(): float;
}
