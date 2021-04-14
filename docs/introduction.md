---
category: Introduction
weight: 0
name: Introduction
---

# Introduction

This is a Laravel package that provides a fluent shopping cart api. It currently supports Items, Coupons and fees which are all stored inside the user session.

Here's what the API looks like:

```
// Using the helper

cart()
    ->items()
    ->add([
        'id' => 1,
        'name' => 'Shoes',
        'price' => 59.99,
        'vat' => 21,
    ]);

// Or the facade

ShoppingCart::items()->add(new Item(
    id: 1,
    name: 'Shoes',
    price: 59.99,
    vat: 21,
));
