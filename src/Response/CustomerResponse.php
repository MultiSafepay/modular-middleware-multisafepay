<?php

namespace ModularMultiSafepay\ModularMultiSafepay\Response;

class CustomerResponse
{
    public function __construct(
        protected string $firstname,
        protected string $lastname,
        protected string $gender,
        protected string $birthday,
        protected string $address1,
        protected string $address2,
        protected string $house_number,
        protected string $zip_code,
        protected string $city,
        protected string $country,
        protected string $phone,
        protected string $email,
    )
    {
    }

    public function toArray()
    {
        return [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'gender' => $this->gender,
            'birthday' => $this->birthday,
            'address1' => $this->address1,
            'address2' => $this->address2,
            'house_number' => $this->house_number,
            'zip_code' => $this->zip_code,
            'city' => $this->city,
            'country' => $this->country,
            'phone' => $this->phone,
            'email' => $this->email,
        ];
    }
}
