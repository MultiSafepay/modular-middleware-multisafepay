<?php

namespace ModularMultiSafepay\ModularMiddlewareMultiSafepay\Response;

class ShoppingCartItemResponse
{
    public function __construct(
        protected string         $name,
        protected string         $description,
        protected float          $unit_price,
        protected int            $quantity,
        protected string         $merchant_item_id,
        protected string         $tax_table_selector,
        protected WeightResponse $weight,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'unit_price' => $this->unit_price,
            'quantity' => $this->quantity,
            'merchant_item_id' => $this->merchant_item_id,
            'tax_table_selector' => $this->tax_table_selector,
            'weight' => $this->weight->toArray(),
        ];
    }
}
