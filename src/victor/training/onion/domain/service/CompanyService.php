<?php

namespace victor\training\onion\domain\service;

use Exception;
use victor\training\onion\infra\onrc\ONRCApiClient;

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
            throw new Exception('There is no single user matching username ' . $cif);
        }

        $onrcle = $list[0];

        $this->deepDomainLogic($onrcle);
    }

    private function deepDomainLogic(array $dto) // ⚠️ useless fields
    {
        echo "send 'Thank you' email to " . $dto["mainEml"];  // ⚠️ bad attribute name

        $year = $dto["registrationDate"]->format('Y');  // ⚠️ what if date is null?
        if (date('Y') - $year < 2) {
            throw new Exception("Too young");
        }

        $this->innocentHack($dto);
        $this->deeper($dto);

        $name = $dto["extendedFullName"] != null ? $dto["extendedFullName"] : $dto["shortName"]; // ⚠️ data mapping mixed with biz logic
        echo "set order placed by $name";
    }

    private function innocentHack(array &$dto): void
    {
        if ($dto["euregno"] == null) {
            $dto["euregno"]="RO" . $dto["onrcId"]; // ⚠️ mutability risks
        }
    }

    private function deeper(array $dto) // ⚠️ useless fields
    {
        $name = $dto["extendedFullName"] != null ? $dto["extendedFullName"] : $dto["shortName"]; // ⚠️ repeated logic
        echo "set shipped to $name, having EU reg: " . $dto["euregno"];
    }
}