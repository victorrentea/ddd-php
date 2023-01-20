<?php

namespace victor\training\onion\insurance\domain\model;

// VALUE OBJECT fac ce vreau in el
//pun logica langa datele  pe care lucreaza = OOP << DDD zice sa faci asta!
readonly class Company
{
    private string $name;
    private string $email;
    private \DateTimeImmutable $registrationDate;
    private string $europeanRegistrationNumber;

    public function __construct(string $name, string $email, \DateTimeImmutable $registrationDate, string $europeanRegistrationNumber)
    {
        $this->name = $name;
        $this->email = $email;
        $this->registrationDate = $registrationDate;
        $this->europeanRegistrationNumber = $europeanRegistrationNumber;
    }

    function isYoung(): bool
    {
        $year = $this->registrationDate->format('Y');  // ⚠️ pending NullPointerException
        return date('Y') - $year < 2;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getEuropeanRegistrationNumber(): string
    {
        return $this->europeanRegistrationNumber;
    }

    public function getRegistrationDate(): \DateTimeImmutable
    {
        return $this->registrationDate;
    }
}
