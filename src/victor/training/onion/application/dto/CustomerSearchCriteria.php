<?php

namespace victor\training\onion\application\dto;

// fields from search form
class CustomerSearchCriteria
{
    private string $name;
    private string $email;
    function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}