<?php

namespace victor\training\onion\domain\service;

use victor\training\onion\domain\model\Company;

interface AnafApiAdapterInterface
{
    public function fetchCompanyByCif(string $cif): Company;
}