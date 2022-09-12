<?php

namespace ModularMultiSafepay\ModularMultiSafepay\Order;

use ModularMultiSafepay\ModularMultiSafepay\IFormatData;

class DeliveryInfo implements IFormatData
{
    public function __construct(
        public string $firstName = "",
        public string $lastName = "",
        public string $address = "",
        public string $houseNumber = "",
        public string $zipCode = "",
        public string $city = "",
        public string $country = "",
        public string $locale = "",
    )
    {
    }

    public function formatData(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'address1' => $this->address,
            'house_number' => $this->houseNumber,
            'zip_code' => $this->zipCode,
            'city' => $this->city,
            'country' => $this->country,
            'locale' => $this->locale,
        ];
    }
}
