<?php

namespace ModularMultiSafepay\ModularMultiSafepay\Order;

class ItemsTable
{
    public static function fromShoppingCart(ShoppingCart $shoppingCart): string
    {
        return '<ul>' .
            array_reduce(
                array_map(
                    static function ($item) {
                        return '<li>' . $item->quantity . 'x ' . $item->name . '</li>';
                    },
                    $shoppingCart->getItems()
                ),
                static function ($carry, $item) {
                    return $carry . $item;
                },
                ''
            ) . '</ul>';
    }
}
