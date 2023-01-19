<?php

namespace victor\training\onion\domain\service;

use Exception;
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

        $onrcle = $list[0];

        $this->deepDomainLogic($onrcle);
    }

    private function deepDomainLogic(ONRCLegalEntityDto $dto) // ⚠️ useless fields
    {
        echo "send 'Thank you' email to " . $dto->getMainEml();  // ⚠️ bad attribute name

        $year = $dto->getRegistrationDate()->format('Y');  // ⚠️ pending NullPointerException
        if (date('Y') - $year < 2) {
            throw new Exception("Company too young");
        }

        // temporal coupling: daca inversezi cele 2 linii de mai jos iti iei bug fara macar sa banuiesti
        // problemele datelor mutabile: codu nu iti exprima dependenta de date
        $this->innocentHack($dto);
        $this->deeper($dto);

        $name = $dto->getExtendedFullName() != null ? $dto->getExtendedFullName() : $dto->getShortName(); // ⚠️ data mapping mixed with biz logic
        echo "set order placed by $name";
    }

    private function innocentHack(ONRCLegalEntityDto $dto): void
    {
        if ($dto->getEuregno() == null) {
            $dto->setEuregno("RO" . $dto->getOnrcId()); // ⚠️ mutability risks
        }
    }

    private function deeper(ONRCLegalEntityDto $dto) // ⚠️ useless fields
    {
        $name = $dto->getExtendedFullName() != null ? $dto->getExtendedFullName() : $dto->getShortName(); // ⚠️ repeated logic
        echo "set shipped to $name, having EU reg: " . $dto->getEuregno();
    }
}
