<?php

namespace victor\training\onion\be\domain\service;

use victor\training\onion\be\domain\model\Company;

interface CompanyFetcherInterface
{
    public function fetchCompanyByCif(string $cif): Company;
}