<?php

namespace victor\training\onion\be\domain\model;

readonly class Company
{
    public function __construct(
        public string $email,
        public int    $registrationYear,
        public string $name,
        public string $euRegistrationNumber,
    )
    {
        // todo alte validari
    }
}