<?php

namespace victor\training\onion\infra;

use Exception;
use victor\training\onion\domain\model\Company;
use victor\training\onion\domain\service\CompanyFetcherInterface;
use victor\training\onion\infra\onrc\ONRCApiClient;

class AnafApiAdapter implements CompanyFetcherInterface
{
    public function __construct(
        private ONRCApiClient $apiClient
    )
    {
    }

    public function fetchCompanyByCif(string $cif): Company
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
        return $company;
    }
}