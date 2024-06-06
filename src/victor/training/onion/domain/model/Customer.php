<?php

namespace victor\training\onion\domain\model;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class Customer
{
    #[Id]
    #[GeneratedValue]
    private int $id;
    #[Column]
    private string $name;
    private string $email;
    private string $address;
    private bool $genius;

    #[Embedded] // NU FACI NICI UN ALTER TABLE; rame la fel tablea
    private ShippingAddress $shippingAddress;

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

    public function getShippingAddress(): ShippingAddress
    {
        return $this->shippingAddress;
    }

    public function setShippingAddress(ShippingAddress $shippingAddress): void
    {
        $this->shippingAddress = $shippingAddress;
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