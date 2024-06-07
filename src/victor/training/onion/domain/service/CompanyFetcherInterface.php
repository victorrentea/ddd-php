<?php

namespace victor\training\onion\domain\service;

use victor\training\onion\domain\model\Company;

interface CompanyFetcherInterface
{
    public function fetchCompanyByCif(string $cif): Company;
}