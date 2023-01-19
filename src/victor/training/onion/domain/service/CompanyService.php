<?php

namespace victor\training\onion\domain\service;

use Exception;
use Safe\DateTimeImmutable;
use victor\training\onion\domain\model\Company;
use victor\training\onion\infra\onrc\ONRCApiClient;
use victor\training\onion\infra\onrc\ONRCLegalEntityDto;

readonly class CompanyService
{

    public function __construct(private readonly ONRCClient $client)
    {
    }

    public function placeCorporateOrder(string $cif): void
    {
        $company = $this->client->fetchCompany($cif);

        echo "send 'Thank you' email to " . $company->getEmail();  // ⚠️ bad attribute name

        if ($company->isYoung()) {
            throw new Exception("Company too young");
        }

        // temporal coupling: daca inversezi cele 2 linii de mai jos iti iei bug fara macar sa banuiesti
        // problemele datelor mutabile: codu nu iti exprima dependenta de date
        $this->deeper($company);

        echo "set order placed by {$company->getName()}";
    }


    private function deeper(Company $company) // ⚠️ useless fields
    {
        echo "set shipped to {$company->getName()}, having EU reg: " . $company->getEuropeanRegistrationNumber();
    }
}
