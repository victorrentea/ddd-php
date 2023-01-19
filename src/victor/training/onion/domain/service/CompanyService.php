<?php

namespace victor\training\onion\domain\service;

use Exception;
use Safe\DateTimeImmutable;
use victor\training\onion\domain\model\Company;
use victor\training\onion\infra\onrc\ONRCApiClient;
use victor\training\onion\infra\onrc\ONRCLegalEntityDto;

readonly class CompanyService
{
    private ONRCApiClient $apiClient;

    public function __construct(ONRCApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function placeCorporateOrder(string $cif): void
    {
        $list = $this->apiClient->search(null, null, strtoupper($cif));
        if (count($list) !== 1) {
            throw new Exception('There is no single company matching CIF= ' . $cif);
        }

        $dto = $list[0];

        $name = $dto->getExtendedFullName() != null ? $dto->getExtendedFullName() : $dto->getShortName(); // ⚠️ data mapping mixed with biz logic
        $company = new Company($name,
            $dto->getMainEml(),
            DateTimeImmutable::createFromMutable($dto->getRegistrationDate()),
            $dto->getEuregno() ?? ("RO" . $dto->getOnrcId())
        );

        $this->deepDomainLogic($company);
    }

    private function deepDomainLogic(Company $company) // ⚠️ useless fields
    {
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
