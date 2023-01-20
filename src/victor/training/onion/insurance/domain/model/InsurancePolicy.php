<?php

namespace victor\training\onion\insurance\domain\model;

use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use victor\training\ddd\agile\ddd\DDDAggregateRoot;
use victor\training\onion\customer\domain\model\Customer;
use victor\training\onion\domain\model\Fix;

#[DDDAggregateRoot]
#[Entity]
class InsurancePolicy
{
    #[Id]
    #[GeneratedValue]
    private int $id;

    private int $customerId; // + FK->Customer (ACID FTW!)
    private string $customerName;
    private string $customerAddress;

    private int $valueInEur;

    public function __construct(int $customerId)
    {
        $this->customerId = $customerId;
    }

    public function setCustomerAddress(string $customerAddress): void
    {
        $this->customerAddress = $customerAddress;
    }

    public function setCustomerName(string $customerName): void
    {
        $this->customerName = $customerName;
    }
    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

    public function getValueInEur(): int
    {
        return $this->valueInEur;
    }

    public function setValueInEur(int $valueInEur): void
    {
        $this->valueInEur = $valueInEur;
    }


}