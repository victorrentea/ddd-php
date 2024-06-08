<?php

namespace victor\training\onion\be\domain\model;

use Doctrine\ORM\Mapping\Embeddable;

// un Value Object nu are ui persistent
// VALUE OBJECT = obiect mic fara PK, imutabil
// = un fel de DTO folosit in Domainul tau.
#[Embeddable]
class ShippingAddress
{
    public function __construct(
        public readonly string $city,
        public readonly string $street,
        public readonly string $zip)
    {
    }
}