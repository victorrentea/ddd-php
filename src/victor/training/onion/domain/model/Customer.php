<?php

namespace victor\training\onion\domain\model;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use victor\training\onion\application\service\CustomerApplicationService;

#[Entity]
class CustomerDoctrineEntity {/*toate campurile ctrl-c/ctrl-v*/}

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

    private CustomerStatus $status = CustomerStatus::DRAFT;
    private ?string $validatedBy; // ⚠ Always🤞 not-null when status = VALIDATED or later

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getStatus(): CustomerStatus {
        return $this->status;
    }
    public function markValidated(string $validatedBy) {
        if ($this->status != CustomerStatus::DRAFT) {
            throw new \InvalidArgumentException("Can't validate a customer that is not in DRAFT status");
        }
        $this->status = CustomerStatus::VALIDATED;
        $this->validatedBy = $validatedBy;
    }
    public function activate() {
        if ($this->status != CustomerStatus::VALIDATED) {
            throw new \InvalidArgumentException("Can't activate a customer that is not in VALIDATED status");
        }
        $this->status = CustomerStatus::ACTIVE;
    }
    public function delete() {
        if ($this->status != CustomerStatus::ACTIVE) {
            throw new \InvalidArgumentException("Can't delete a customer that is not in VALIDATED status");
        }
        $this->status = CustomerStatus::DELETED;
    }


    public function getValidatedBy(): ?string
    {
        return $this->validatedBy;
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

    // public function f(AltaEntitateCu50Campuri $rau)
    // public function f(UnService $rau, UnApiCaller $imaiRau, EntityManager $atat) < NICIODATA
    public function getDiscount(): int
    {
        $discountPercentage = 3;
        if ($this->isGenius()) {
            $discountPercentage = 4;
        }
        return $discountPercentage;
    }
}

//region Code in the project might [not] follow the rule
function ok(Customer $draftCustomer) {
    $draftCustomer->markValidated("user");
}
function notOk(Customer $draftCustomer) {
    $draftCustomer->markValidated("user");
}
function ok2(Customer $activeCustomer) {
    $activeCustomer->delete();
}
//endregion