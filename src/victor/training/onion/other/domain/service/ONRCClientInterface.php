<?php

namespace victor\training\onion\other\domain\service;

use victor\training\onion\other\domain\model\Company;

interface ONRCClientInterface
{
    public function fetchCompany(string $cif): Company;
}