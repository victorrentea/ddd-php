<?php

namespace victor\training\onion\domain\service;

use victor\training\onion\domain\model\Company;

interface ONRCClientInterface
{
    public function fetchCompany(string $cif): Company;
}