<?php

namespace victor\training\onion\insurance\domain\service;

use victor\training\onion\insurance\domain\model\Company;

interface ONRCClientInterface
{
    public function fetchCompany(string $cif): Company;
}