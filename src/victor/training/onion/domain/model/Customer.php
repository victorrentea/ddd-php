<?php

namespace victor\training\onion\domain\model;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class Customer
{
    #[Id]
    #[GeneratedValue]
    private int $id;
    private string $name;
    private string $email;
    private string $address;
    private bool $genius;

    // 🤔 Hmm... 3 fields with the same prefix. What TODO ?
    private string $shippingAddressCity;
    private string $shippingAddressStreet;
    private string $shippingAddressZip;

    private ?CustomerStatus $status;
    private ?string $validatedBy; // ⚠ Always not-null when status = VALIDATED or later

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getStatus(): ?CustomerStatus
    {
        return $this->status;
    }

    public function setStatus(?CustomerStatus $status): Customer
    {
        $this->status = $status;
        return $this;
    }

    public function getValidatedBy(): ?string
    {
        return $this->validatedBy;
    }

    public function setValidatedBy(?string $validatedBy): Customer
    {
        $this->validatedBy = $validatedBy;
        return $this;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Customer
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): Customer
    {
        $this->email = $email;
        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): Customer
    {
        $this->address = $address;
        return $this;
    }

    public function isGenius(): bool
    {
        return $this->genius;
    }

    public function setGenius(bool $genius): Customer
    {
        $this->genius = $genius;
        return $this;
    }

    public function getShippingAddressCity(): string
    {
        return $this->shippingAddressCity;
    }

    public function getShippingAddressStreet(): string
    {
        return $this->shippingAddressStreet;
    }

    public function getShippingAddressZip(): string
    {
        return $this->shippingAddressZip;
    }

    public function setShippingAddressCity(string $shippingAddressCity): Customer
    {
        $this->shippingAddressCity = $shippingAddressCity;
        return $this;
    }

    public function setShippingAddressStreet(string $shippingAddressStreet): Customer
    {
        $this->shippingAddressStreet = $shippingAddressStreet;
        return $this;
    }

    public function setShippingAddressZip(string $shippingAddressZip): Customer
    {
        $this->shippingAddressZip = $shippingAddressZip;
        return $this;
    }
}

//region Code in the project might [not] follow the rule
function ok(Customer $draftCustomer) {
    $draftCustomer->setStatus(CustomerStatus::VALIDATED);
    $draftCustomer->setValidatedBy("currentUser"); // from token/session..
}
function notOk(Customer $draftCustomer) {
    $draftCustomer->setStatus(CustomerStatus::VALIDATED);
}
//endregion