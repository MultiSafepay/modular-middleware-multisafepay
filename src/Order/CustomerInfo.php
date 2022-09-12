<?php

namespace ModularMultiSafepay\ModularMiddlewareMultiSafepay\Order;

class CustomerInfo extends DeliveryInfo
{
    public function __construct(
        string         $firstName,
        string         $lastName,
        public string  $birthday,
        public string  $phone,
        public string  $email,
        public string  $gender,
        string         $address,
        string         $houseNumber,
        string         $zipCode,
        string         $city,
        string         $country,

        public string  $locale = 'en_US',
        public ?string $ipAddress = null,
        public ?string $forwardedIp = null,
        public ?string $userAgent = null,
    )
    {
        parent::__construct($firstName, $lastName, $address, $houseNumber, $zipCode, $city, $country, $locale);
    }

    public function formatData(): array
    {
        $customerInfo = array_merge(
            parent::formatData(),
        [
            'birthday' => $this->birthday,
            'phone' => $this->phone,
            'email' => $this->email,
            'gender' => $this->gender,
            'locale' => $this->locale,
        ]);

        if ($this->ipAddress) {
            $customerInfo['ip_address'] = $this->ipAddress;
        }

        if ($this->forwardedIp) {
            $customerInfo['forwarded_ip'] = $this->forwardedIp;
        }

        if ($this->userAgent) {
            $customerInfo['user_agent'] = $this->userAgent;
        }

        return $customerInfo;
    }
}
