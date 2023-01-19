<?php

namespace victor\training\onion\domain\service;

use Safe\DateTimeImmutable;
use victor\training\onion\domain\model\Company;

class ONRCClient
{ // adapter peste api-ul onrc
//class CompanyFactory - a la Craiova
//class CompanyRepository - un repo scrie in DB MEU
//class CompanyBuilder - fals. Un builder nu construieste el obiect ci ofera API de constructie catre restul codului. face api call extern
//class ONRCAdapter { // aka "client"

    public function fetchCompany(string $cif): Company
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
        return $company;
    }
}