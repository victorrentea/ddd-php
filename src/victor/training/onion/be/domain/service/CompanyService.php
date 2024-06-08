<?php

namespace victor\training\onion\be\domain\service;

use Exception;
use victor\training\onion\be\domain\model\Company;
use function date;

readonly class CompanyService
{
    public function __construct(
        private readonly CompanyFetcherInterface $apiAdapter)
    {
    }

    public function placeCorporateOrder(string $cif): void
    {
        $company = $this->fetchCompanyByCif($cif);
        echo "send 'Thank you' email to " . $company->email;

        // biz logic sfant 🧘☯️
        if (date('Y') - $company->registrationYear < 2) {
            throw new Exception("Too young");
        }
        // biz logic sfant 🧘☯️

        $this->deeper($company);
        // biz logic sfant 🧘☯️
        echo "set order placed by {$company->name}";
    }


    private function deeper(Company $company) // ⚠️ useless fields
    {
        $name = $company->name;
        echo "set shipped to $name, having EU reg: " . $company->euRegistrationNumber;
    }


}