<?php

namespace ModularMultiSafepay\ModularMiddlewareMultiSafepay\Order;

use App\Data\Multisafepay\IFormatData;

class Item implements IFormatData
{
    public function __construct(
        public string $id,
        public string $name,
        public float  $price,
        public int    $quantity,
        public float  $tax,
        public string $description = '',
    )
    {
    }

    public function formatData(): array
    {
        return [
            'name' => $this->name,
            'merchant_item_id' => $this->id,
            'unit_price' => $this->price,
            'quantity' => $this->quantity,
            'tax_table_selector' => $this->tax,
            'description' => $this->description,
        ];
    }
}
