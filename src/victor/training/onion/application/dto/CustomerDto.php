<?php

namespace victor\training\onion\application\dto;

// JSON
class CustomerDto
{
    private string $name;
    private string $email;
    private string $address;
    private string $shippingAddressCity;
    private string $shippingAddressStreet;
    private string $shippingAddressZip;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): CustomerDto
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): CustomerDto
    {
        $this->email = $email;
        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): CustomerDto
    {
        $this->address = $address;
        return $this;
    }

    public function getShippingAddressCity(): string
    {
        return $this->shippingAddressCity;
    }

    public function setShippingAddressCity(string $shippingAddressCity): CustomerDto
    {
        $this->shippingAddressCity = $shippingAddressCity;
        return $this;
    }

    public function getShippingAddressStreet(): string
    {
        return $this->shippingAddressStreet;
    }

    public function setShippingAddressStreet(string $shippingAddressStreet): CustomerDto
    {
        $this->shippingAddressStreet = $shippingAddressStreet;
        return $this;
    }

    public function getShippingAddressZip(): string
    {
        return $this->shippingAddressZip;
    }

    public function setShippingAddressZip(string $shippingAddressZip): CustomerDto
    {
        $this->shippingAddressZip = $shippingAddressZip;
        return $this;
    }


}