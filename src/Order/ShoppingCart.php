<?php

namespace ModularMultiSafepay\ModularMiddlewareMultiSafepay\Order;

use ModularMultiSafepay\ModularMiddlewareMultiSafepay\IFormatData;

class ShoppingCart implements IFormatData
{
    /**
     * @param array<Item> $items
     */
    public function __construct(
        public array $items = [],
    )
    {
    }

    /**
     * @return array<Item>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function formatData(): array
    {
        return ['items' => array_map(static fn($item) => $item->formatData(), $this->items)];
    }
}
