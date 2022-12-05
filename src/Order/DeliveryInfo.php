<?php

namespace ModularMultiSafepay\ModularMultiSafepay\Order;

use ModularMultiSafepay\ModularMultiSafepay\IFormatData;
use ModularMultiSafepay\ModularMultiSafepay\MultiSafepay;

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
        if (empty($this->houseNumber)){
            $SplitAddress = $this->parse($this->address);

            if (isset($SplitAddress['housenumber']))
                $this->houseNumber = $SplitAddress['housenumber'];

            $this->address = $SplitAddress['streetname'];
        }

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

    /**
     * @return array
     */
    public function parse(string $address, string $address2 = ""){
        $fullAddress  = trim($address . $address2);

        $fullAddress = preg_replace('/[[:blank:]]+/', ' ', $fullAddress);

        //Used for numbers in the back of the address
        $pattern = '/(.+?)\s?([\d]+[\S]*)((\s?[A-z])*?)$/';

        //Check if the number is in the front\
        if (is_numeric($fullAddress[0])){
            $pattern = '/([\d]+[\S]*)(\s?\w{0,1}\s)(.+?)$/';
        }

        preg_match($pattern, $fullAddress, $matches);

        //If everything fails then return full address
        if (!$matches) {
            return ['streetname' => $fullAddress];
        }
        return $this->stripParse($matches);

    }

    /**
     * @return array
     */
    public function stripParse($matches)
    {
        $group1 = $matches[1] ?? '';
        $group2 = $matches[2] ?? '';
        $group3 = $matches[3] ?? '';

        if (is_numeric($group1[0])) {
            return ['streetname' => trim($group3), 'housenumber' => trim($group1 . $group2)];
        }
        return ['streetname' => trim($group1),'housenumber' => trim($group2 . $group3)];
    }
}
