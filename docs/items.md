---
category: Usage
weight: 3
name: Items
---

# Items

Items reflect the "Products" in your app. We assume you pass along the price without VAT. You should create an accessor which retrieves the price without VAT if your stored prices include VAT.

# Fetching items

You can retrieve all items by running:

```
cart()
    ->items()
    ->get();
```

This will return a `Collection` of `Item` objects.

# Removing items

You can remove items by specifying their id:

```
cart()
    ->items()
    ->remove(1);
```

# Incrementing quantity

You can increment an item's quantity by as much as you like, the default value is 1:

```
cart()
    ->items()
    ->increment(id: 1, byAmount: 4);

cart()
    ->items()
    ->increment(id: 1);
```

If you calculate prices based on attributes such as colors and sizes you should hash the object and use that as id.

# Decrementing quantity

You can decrement an item's quantity by as much as you like, the default value is 1:

```
cart()
    ->items()
    ->decrement(id: 1, byAmount: 4);

cart()
    ->items()
    ->decrement(id: 1);
```

If you calculate prices based on attributes such as colors and sizes you should hash the object and use that as id.

# Updating items

You should update an item by passing the whole object with the same id, we resolve the id from the object.

```
$item = cart()->find(1);

$item->vat = 19.00;

cart()
    ->items()
    ->update($item);
```

# Counting items

Countinge items can be usefull if you want to show a shopping cart with the amount of items. We calculate this by the amount of items times their quantity.

```
cart()
    ->items()
    ->count();
```

# Retrieving VAT

You can retrieve the total amount of VAT by running:

```
cart()
    ->items()
    ->vat();
```

# Calculating (sub)totals

You can retrieve the total by running:

```
cart()
    ->items()
    ->total(withVat: true, withCoupons: true);
```

This will apply the global coupons before VAT.

# Emptying items

You can empty all (and only) items by running:

```
cart()
    ->items()
    ->empty();
```

This will still keep your coupons and fees.

# Finding items

You can find an items by their id by running:

```
cart()
    ->items()
    ->find(id: 1); // return Item instance
```

# Determining existence

You can determine an item's existence by checking against their id:

```
cart()
    ->items()
    ->has(id: 1); // return true or false
```
