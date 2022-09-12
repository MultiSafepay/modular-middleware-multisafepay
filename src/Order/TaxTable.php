<?php

namespace ModularMultiSafepay\ModularMultiSafepay\Order;

class TaxTable
{
    public static function fromShoppingCart(ShoppingCart $shoppingCart): array
    {
        $uniqueRates = array_unique(array_merge(array_map(static fn($item) => $item->tax, $shoppingCart->items), [0]));
        return [
            'alternate' => array_values(array_map(static function ($rate) {
                return [
                    'name' => '' . $rate,
                    'standalone' => true,
                    'rules' => [
                        [
                            'rate' => $rate
                        ]
                    ]
                ];
            }, $uniqueRates))
        ];
    }
}
