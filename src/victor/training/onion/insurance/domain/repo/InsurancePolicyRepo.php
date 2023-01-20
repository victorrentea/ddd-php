<?php

namespace victor\training\onion\insurance\domain\repo;

use victor\training\onion\insurance\domain\model\InsurancePolicy;

interface InsurancePolicyRepo
{

    public function findByCustomerId($customerId):InsurancePolicy;

    public function findById(int $id):InsurancePolicy;
}