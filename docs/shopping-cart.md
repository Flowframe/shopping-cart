---
category: Usage
weight: 3
name: Shopping cart
---

# Shopping cart

The shoping cart is the core of this packages. It exposed 3 managers: `ItemManager`, `CouponManager` and `FeeManager` which are in charge of managing state. The state is stored inside a session `shopping_cart`.

## Methods

### Empty

`empty()` will empty all managers by clearing the `shopping_cart` session.

```
cart()->empty();
```

### Total

`total(withVat: true, withFees: true, withCoupons: true)` will compute the total. You can specify if the calculation should include, VAT, Fees and coupons.

**Note:** coupons are applied before VAT and fees will be added after the coupons have been applied.

```
cart()->total(withVat: true, withFees: true, withCoupons: true);
```
