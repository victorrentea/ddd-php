<?php

namespace victor\training\onion\domain\model;

use Doctrine\ORM\Mapping\Embeddable;

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