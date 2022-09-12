<?php declare(strict_types=1);


namespace ModularMultiSafepay\ModularMultiSafepay\Response\PaymentMethod;


final class PaymentMethod
{
    public function __construct(
        public string $id,
        public string $name,
        public AllowedAmount $allowedAmount,
        public array $allowedCurrencies,
        public string $iconUrl,
        public bool $hasComponent
    )
    {
    }
}
