<?php

namespace victor\training\onion\domain\model;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity]
class InsurancePolicy
{
    #[Id]
    #[GeneratedValue]
    private int $id;

    #[ManyToOne]
    private Customer $customer;

    private int $valueInEur;

}