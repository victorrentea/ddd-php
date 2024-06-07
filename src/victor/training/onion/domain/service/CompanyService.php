<?php

namespace victor\training\onion\domain\service;

use Exception;
use victor\training\onion\domain\model\Company;
use victor\training\onion\infra\onrc\ONRCApiClient;

readonly class CompanyService
{
    public function __construct(private ONRCApiClient $apiClient)
    {
    }

    public function placeCorporateOrder(string $cif): void
    {
        $list = $this->apiClient->search(null, null, strtoupper($cif));
        if (count($list) !== 1) {
            throw new Exception('There is no single user matching username ' . $cif);
        }

        $onrcle = $list[0];
        $company = new Company(
            $onrcle["mainEml"], // ⚠️ bad attribute name
            $onrcle["registrationDate"]?->format('Y'), // ⚠️ what if date is null?
            $onrcle["extendedFullName"] ?? $onrcle["shortName"], // ⚠️ data mapping mixed with biz logic
            $onrcle["euregno"] ?? "RO" . $onrcle["onrcId"] // ⚠️ mutability risks
        );
        $this->deepDomainLogic($company);
    }

    private function deepDomainLogic(Company $company)
    {
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