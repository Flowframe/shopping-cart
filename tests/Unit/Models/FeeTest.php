<?php

use Flowframe\ShoppingCart\Models\Fee;

beforeEach(function () {
    $this->fee = new Fee(
        id: 'shipping',
        name: 'Shipping',
        price: 5.00,
        vat: 21,
    );
});

it('can calculate the vat decimal', function () {
    expect($this->fee->vatDecimal())->toBe(1.21);
});

it('can calculate the vat', function () {
    expect($this->fee->vat())->toBe(1.05);
});

it('can calculate the total with vat', function () {
    expect($this->fee->totalWithVat())->toBe(6.05);
});

it('can calculate the total without vat', function () {
    expect($this->fee->totalWithoutVat())->toBe(5.00);
});

it('can calculate the total', function () {
    expect($this->fee->total(withVat: true))->toBe(6.05);

    expect($this->fee->total(withVat: false))->toBe(5.00);
});
