<?php

namespace ModularMultiSafepay\ModularMultiSafepay\Response;

class ShoppingCartResponse
{
    public function __construct(
        public array $items
    ) {
        $mappedItems = collect($this->items)->map(function ($item) {
            return (new ShoppingCartItemResponse(
                $item['productTitle'],
                $item['productTitle'],
                $item['basePriceIncl'],
                $item['quantityOrdered'],
                $item['id'],
                $item['taxRates'][0]['name'],
                new WeightResponse(
                    'kg',
                    ($item['weight'] / 1000)
                )
            ))->toArray();
        })->toArray();

        $this->items = $mappedItems;
    }

    public function toArray(): array
    {
        return [
            'items' => $this->items,
        ];
    }
}
